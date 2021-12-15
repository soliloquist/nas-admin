<?php

namespace App\Http\Livewire\Work;

use App\Models\Block;
use App\Models\Credit;
use App\Models\Language;
use App\Models\Specialty;
use App\Models\Tag;
use App\Models\Work;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $max; // 最後順序
    public $langs;
    public $languageSelected = 1;
    public $image;
    public $thumbnail;
    public $iteration = 0; // for file input cleaning file name
    public $uploadLabel = '上傳圖檔';
    public $thumbnailLabel = '上傳縮圖';

    public $saveButtonText = 'save';

    // Item 資料
    public $slug;
    public $sort;
    public $title;
    public $websiteUrl;
    public $videoUrl;

    // Block 編輯相關
    public $showBlockEditor = false;
    public $blockEditorType = 'text'; // text|photo|album
    public $blockEditorId = null;
    public $blockEditorTextContent = null;
    public $blockEditorSort = null;
    public $blockEditorModel = null;

    public $blocks = [];

    public $specialties = [];

    public $credits = [];

    public $tags = [];

    public $tagOptions = [];

    public $showAlert = false;

    public $groupId; // 新增之後才會產生，為了給新增之後跳轉到編輯頁使用

    protected $listeners = [
        'EDITOR_CREATED' => 'editorCreated',
        'EDITOR_UPDATED' => 'editorUpdated',
        'PHOTO_BLOCK_CREATED' => 'photoBlockCreated',
        'PHOTO_BLOCK_UPDATED' => 'photoBlockUpdated',
        'ALBUM_BLOCK_CREATED' => 'albumBlockCreated',
        'ALBUM_BLOCK_UPDATED' => 'albumBlockUpdated',
        'CREATED_CANCEL' => 'gotoIndex',
        'CREATED_CONFIRM' => 'createdConfirm',
        'CREATED_CONTINUE' => 'createAnotherOne'
    ];

    protected $validationAttributes = [
        'title' => '名稱',
        'slug' => '網址',
        'credits.*.title' => 'Team 名稱'
    ];

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 5MB',
        'thumbnail.image' => '圖檔必須為 jpg,gif,png 格式',
        'thumbnail.max' => '圖檔不可超過 5MB',
        'slug.unique' => '網址重覆',
        'languageSelected.required' => '至少要選擇一種語言'
    ];

    protected $rules = [
        'slug' => 'required|unique:works',
        'title' => 'required|string',
        'websiteUrl' => 'nullable|url',
        'videoUrl' => 'nullable|url',
        'sort' => 'integer',
        'specialties.*.rate' => 'integer',
        'credits.*.title' => 'required|string',
        'credits.*.people' => 'required|array',
        'image' => 'required|image|max:6000',
        'thumbnail' => 'nullable|image|max:6000',
        'languageSelected' => 'required'
    ];


    public function mount()
    {
        $this->langs = Language::all();

        $this->max = Work::groupBy('group_id')->get()->count() + 1;
        $this->sort = 1;

        $this->tagOptions = Tag::all();

        $this->specialties = Specialty::get()->map(function ($item) {

            return [
                'id' => $item->id,
                'name' => $item->name,
                'color' => $item->color,
                'rate' => 0
            ];
        });
    }

    public function render()
    {
        return view('livewire.work.create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedSort($sort)
    {
        if ($sort > $this->max) {
            $this->sort = $this->max;
        } elseif ($sort < 1) {
            $this->sort = 1;
        }
    }

    public function save()
    {
        $this->validate();

        // 產生 group id
        $this->groupId = (string) Str::orderedUuid();

        // 圖檔處理
        $path = $this->image->store('images');
        $image = getimagesize(storage_path('app/' . $path));
        $width = $image[0];
        $height = $image[1];
        $this->reset('image');
        // END 圖檔處理

        //  有上傳 thumbnail
        $thumbnailPath = null;
        if ($this->thumbnail) {

            $thumbnailPath = $this->thumbnail->store('images');
            $this->reset('thumbnail');
        }
        // END 有上傳/更新 thumbnail

        // Specialties 處理
        $specialties = [];

        foreach ($this->specialties as $s) {
            if ($s['rate']) {
                $specialties[$s['id']] = ['percentage' => $s['rate']];
            }
        }
        // END Specialties 處理


        // 處理多語系的 work 新增


        // 重新排序
        Work::where('sort', '>=', $this->sort)->increment('sort');


        foreach ($this->langs as $lang) {

            $work = new Work();
            $work->language_id = $lang->id;
            $work->group_id = $this->groupId;
            $work->title = $this->title;
            $work->slug = $this->slug;
            $work->sort = $this->sort;
            $work->enabled = $lang->id == $this->languageSelected ? 1 : 0;
            $work->save();



            $work->addMediaFromDisk($path)
                ->preservingOriginal()
                ->withCustomProperties(['width' => $width, 'height' => $height])
                ->toMediaCollection();

            if ($thumbnailPath) {
                $work->addMediaFromDisk($thumbnailPath)
                    ->preservingOriginal()
                    ->withCustomProperties(['width' => 600, 'height' => 600])
                    ->toMediaCollection('thumbnail');
            }

            // 處理 credit 資料
            $credits = [];

            foreach ($this->credits as $key => $c) {

                $this->credits[$key]['people'] = array_filter($this->credits[$key]['people']);
                $p = json_encode($this->credits[$key]['people']);

                $credits[$key] = new Credit();
                $credits[$key]->people = $p;
                $credits[$key]->title = $c['title'];
            }

            $work->credits()->saveMany($credits);
            // End 處理 credit 資料


            $work->specialties()->sync($specialties);

            $work->tags()->sync($this->tags);

            // 處理 Block 資料
            if ($lang->id == $this->languageSelected) {

                $blocks = [];

                for ($i = 0; $i < count($this->blocks); $i ++) {
                    $blocks[$i] = Block::find($this->blocks[$i]['id']);
                    $blocks[$i]->sort = $this->blocks[$i]['sort'];
                }
                $work->articles()->saveMany($blocks);
            }

            // END 處理 Block 資料

            $duplicate = true;
        }
        // END 處理多語系的 work 新增

        // 刪掉暫存的圖檔
        Storage::delete($path);
        if ($thumbnailPath) Storage::delete($thumbnailPath);
        // END 刪掉暫存的圖檔

        $this->showAlert = true;
    }


    /**
     * Rate 給分
     * @param $rate
     * @param $id
     */
    public function setRate($rate, $id)
    {
        $this->specialties = $this->specialties->map(function ($item) use ($rate, $id) {
            if ($item['id'] == $id) $item['rate'] = $rate;
            return $item;
        });
    }

    /****************************
     *
     * **** Credit 相關 *****
     *
     ****************************/

    public function onClickAddCredit()
    {
        $this->credits[] = [
            'id' => null,
            'title' => null,
            'people' => [null]
        ];
    }

    public function onClickRemoveCredit($index)
    {
        array_splice($this->credits, $index, 1);
    }

    public function onClickAddCreditPeople($index)
    {
        $this->credits[$index]['people'][] = null;
    }

    /****************************
     *
     * ****  Image 相關 *****
     *
     ****************************/

    public function resetImage()
    {
        $this->reset('image');
        $this->iteration++;
    }

    /****************************
     *
     * ****  Thumbnail 相關 *****
     *
     ****************************/

    public function resetThumbnail()
    {
        $this->reset('thumbnail');
        $this->iteration++;
    }


    /****************************
     *
     * ****  Block 相關 *****
     *
     ****************************/

    /**
     * 按下新增 text 區塊
     */
    public function onClickAddTextBlock()
    {
        $this->blockEditorId = null;
        $this->blockEditorType = 'text';
        $this->blockEditorTextContent = null;
        $this->blockEditorSort = null;
        $this->showBlockEditor = true;
    }

    public function editTextBlock($block)
    {
        $this->blockEditorType = 'text';
        $this->blockEditorModel = Block::find($block['id']);
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function editorCreated($blockId)
    {
        $block = Block::find($blockId);

        $this->blocks[] = [
            'id' => $blockId,
            'type' => 'text',
            'content' => $block->content,
            'sort' => count($this->blocks) + 1,
            'edit' => false
        ];

        $this->showBlockEditor = false;
    }


    /**
     * 按下新增 photo 區塊
     */
    public function onClickAddPhotoBlock()
    {
        $this->blockEditorId = null;
        $this->blockEditorType = 'photo';
        $this->blockEditorTextContent = null;
        $this->blockEditorSort = null;
        $this->showBlockEditor = true;
    }

    public function photoBlockCreated($blockId)
    {
        $images = [];

        foreach (Block::find($blockId)->getMedia() as $media) {
            $images[] = [
                'caption' => $media->getCustomProperty('caption'),
                'fullUrl' => $media->getFullUrl()
            ];
        }

        $this->blocks[] = [
            'id' => $blockId,
            'type' => 'photo',
            'content' => $images,
            'sort' => count($this->blocks) + 1,
            'edit' => false
        ];

        $this->showBlockEditor = false;
    }

    public function editPhotoBlock($block)
    {
        $this->blockEditorType = 'photo';
        $this->blockEditorModel = Block::find($block['id']);
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function photoBlockUpdated($blockId)
    {
        $images = [];

        foreach (Block::find($blockId)->getMedia() as $media) {
            $images[] = [
                'caption' => $media->getCustomProperty('caption'),
                'fullUrl' => $media->getFullUrl()
            ];
        }

        foreach ($this->blocks as $key => $value) {
            if ($value['type'] == 'photo' && $value['id'] == $blockId) {
                $this->blocks[$key]['content'] = $images;
            }
        }

        $this->showBlockEditor = false;
    }

    /**
     * 按下新增 album 區塊
     */
    public function onClickAddAlbumBlock()
    {
        $this->blockEditorId = null;
        $this->blockEditorType = 'album';
        $this->blockEditorTextContent = null;
        $this->blockEditorSort = null;
        $this->showBlockEditor = true;
    }
    public function editAlbumBlock($block)
    {
        $this->blockEditorType = 'album';
        $this->blockEditorModel = Block::find($block['id']);
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function albumBlockCreated($blockId)
    {
        $images = [];

        foreach (Block::find($blockId)->getMedia() as $media) {
            $images[] = [
                'fullUrl' => $media->getFullUrl()
            ];
        }

        $this->blocks[] = [
            'id' => $blockId,
            'type' => 'album',
            'content' => $images,
            'sort' => count($this->blocks) + 1,
            'edit' => false
        ];

        $this->showBlockEditor = false;
    }

    public function albumBlockUpdated($blockId)
    {
        $images = [];

        foreach (Block::find($blockId)->getMedia() as $media) {
            $images[] = [
                'fullUrl' => $media->getFullUrl()
            ];
        }

        foreach ($this->blocks as $key => $value) {
            if ($value['id'] == $blockId) {
                $this->blocks[$key]['content'] = $images;
            }
        }

        $this->showBlockEditor = false;
    }

    /**
     * 按下 編輯區塊 按鈕
     */
    public function onClickEditBlock($sort)
    {
        foreach ($this->blocks as $key => $value) {
            if ($value['sort'] == $sort) {

                switch ($value['type']) {

                    case 'text':

                        $this->editTextBlock($value);
                        break;

                    case 'photo':

                        $this->editPhotoBlock($value);
                        break;

                    case 'album':

                        $this->editAlbumBlock($value);
                        break;

                }

                break;
            }
        }
    }

    public function onCloseEditBlock()
    {
        $this->showBlockEditor = false;
        $this->reset(['blockEditorSort', 'blockEditorTextContent', 'blockEditorId', 'blockEditorType', 'blockEditorModel']);
    }

    public function onClickRemoveBlock($sort)
    {
        foreach ($this->blocks as $key => $value) {
            if ($value['sort'] == $sort) {

                unset($this->blocks[$key]);
            }
        }
    }

    public function sortDecrease($sort)
    {
        foreach ($this->blocks as $key => $item) {

            if ($item['sort'] == $sort) {
                $this->blocks[$key]['sort']--;
            }

            if ($item['sort'] == $sort - 1) {
                $this->blocks[$key]['sort']++;
            }
        }

        $this->resortingBlocks();
    }

    public function sortIncrease($sort)
    {
        foreach ($this->blocks as $key => $item) {

            if ($item['sort'] == $sort) {
                $this->blocks[$key]['sort']++;
            }

            if ($item['sort'] == $sort + 1) {
                $this->blocks[$key]['sort']--;
            }
        }

        $this->resortingBlocks();
    }

    public function editorUpdated($blockId)
    {
        $block = Block::find($blockId);

        foreach ($this->blocks as $key => $value) {
            if ($value['type'] == 'text' && $value['id'] == $blockId) {
                $this->blocks[$key]['content'] = $block->content;
            }
        }

        $this->showBlockEditor = false;
    }

    public function resortingBlocks()
    {
        $this->blocks = array_values(Arr::sort($this->blocks, function ($value) {
            return $value['sort'];
        }));
    }

    // 新增完成後處理
    public function gotoIndex()
    {
        return redirect()->route('works.index');
    }

    public function createAnotherOne()
    {
        return redirect()->route('works.create');
    }

    public function createdConfirm()
    {
        return redirect()->route('works.edit', ['groupId' => $this->groupId, 'languageId' => $this->languageSelected]);
    }

}
