<?php

namespace App\Http\Livewire\Business;

use App\Models\Block;
use App\Models\Credit;
use App\Models\Language;
use App\Models\Specialty;
use App\Models\Tag;
use App\Models\Business;
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
    public $languageSelected = [];
    public $image;
    public $iteration = 0; // for file input cleaning file name
    public $uploadLabel = '上傳圖檔';

    public $saveButtonText = 'save';

    // Item 資料
    public $enabled = false;
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

    public $showAlert = false;

    protected $listeners = [
        'EDITOR_CREATED' => 'editorCreated',
        'EDITOR_UPDATED' => 'editorUpdated',
        'PHOTO_BLOCK_CREATED' => 'photoBlockCreated',
        'PHOTO_BLOCK_UPDATED' => 'photoBlockUpdated',
        'ALBUM_BLOCK_CREATED' => 'albumBlockCreated',
        'ALBUM_BLOCK_UPDATED' => 'albumBlockUpdated',
        'CREATED_CANCEL' => 'gotoIndex',
        'CREATED_CONFIRM' => 'createAnotherOne'
    ];

    protected $validationAttributes = [
        'title' => '名稱',
        'slug' => '網址',
    ];

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 5MB',
        'slug.unique' => '網址重覆',
        'languageSelected.required' => '至少要選擇一種語言'
    ];

    protected $rules = [
        'slug' => 'required|unique:works',
        'title' => 'required|string',
        'websiteUrl' => 'nullable|url',
        'videoUrl' => 'nullable|url',
        'enabled' => 'boolean',
        'sort' => 'integer',
        'image' => 'required|image|max:6000',
        'languageSelected' => 'required'
    ];


    public function mount()
    {
        $this->langs = Language::all();

        $this->max = Business::groupBy('group_id')->get()->count() + 1;
        $this->sort = $this->max;

    }

    public function render()
    {
        return view('livewire.business.create');
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
        $groupId = (string) Str::orderedUuid();

        // 圖檔處理
        $path = $this->image->store('images');
        $image = getimagesize(storage_path('app/' . $path));
        $width = $image[0];
        $height = $image[1];
        $this->reset('image');
        // END 圖檔處理


        // 處理多語系的 work 新增


        // 重新排序
        Business::where('sort', '>=', $this->sort)->increment('sort');

        $duplicate = false; // 是否為第二個以上的語系
        foreach ($this->langs as $lang) {

            $work = new Business();
            $work->language_id = $lang->id;
            $work->group_id = $groupId;
            $work->title = $this->title;
            $work->slug = $this->slug;
            $work->sort = $this->sort;
            $work->enabled = in_array($lang->id, $this->languageSelected) ? 1 : 0;
            $work->save();

            $work->addMediaFromDisk($path)
                ->preservingOriginal()
                ->withCustomProperties(['width' => $width, 'height' => $height])
                ->toMediaCollection();


            // 處理 Block 資料
            $blocks = [];

            for ($i = 0; $i < count($this->blocks); $i ++) {

                if ($duplicate) {
                    $original = Block::find($this->blocks[$i]['id']);
                    $newBlock = $original->replicate();
                    $newBlock->save();

                    if ($newBlock->type == 'photo' || $newBlock->type == 'album') {

                        foreach ($original->getMedia() as $media) {

                            $newBlock->addMedia($media->getPath())->preservingOriginal()->toMediaCollection();
                        }
                    }

                    $blocks[$i] = $newBlock;

                } else {
                    $blocks[$i] = Block::find($this->blocks[$i]['id']);
                    $blocks[$i]->sort = $this->blocks[$i]['sort'];
                }

            }
            $work->articles()->saveMany($blocks);
            // END 處理 Block 資料

            $duplicate = true;
        }
        // END 處理多語系的 work 新增

        // 刪掉暫存的圖檔
        Storage::delete($path);
        // END 刪掉暫存的圖檔

        $this->showAlert = true;
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
        return redirect()->route('businesses.index');
    }

    public function createAnotherOne()
    {
        return redirect()->route('businesses.create');
    }

}
