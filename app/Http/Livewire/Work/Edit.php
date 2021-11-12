<?php

namespace App\Http\Livewire\Work;

use App\Models\Block;
use App\Models\Specialty;
use App\Models\Work;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Work $work;
    public $image;
    public $iteration = 0; // for file input cleaning file name
    public $max;
    public $sort;
    public $uploadLabel = '上傳圖檔';
    public $groupId;
    public $languageId;
    public $videoUrl;
    public $saveButtonText = 'save';

    public $showAlert = false;

    // Block 編輯相關
    public $showBlockEditor = false;
    public $blockEditorType = 'text'; // text|photo|album
    public $blockEditorId = null;
    public $blockEditorTextContent = null;
    public $blockEditorSort = null;
    public $blockEditorModel = null;

    public $specialties = [];

    public $blocks = [];

    protected $listeners = [
        'EDITOR_UPDATED' => 'editorUpdated',
        'PHOTO_BLOCK_CREATED' => 'photoBlockCreated',
        'PHOTO_BLOCK_UPDATED' => 'photoBlockUpdated',
        'ALBUM_BLOCK_CREATED' => 'photoBlockCreated',
        'ALBUM_BLOCK_UPDATED' => 'photoBlockUpdated',
        'ALERT_DONE' => 'alertDone',
        'RATING_UPDATE' => 'ratingUpdated'
    ];

    protected $validationAttributes = [
        'work.title' => '名稱',
        'work.slug' => '網址',
    ];

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 1MB',
    ];

    protected function rules()
    {
        $rules = [
            'work.language_id' => 'required|integer',
            'work.group_id' => 'required|uuid',
            'work.slug' => 'required',
            'work.title' => 'required|string',
            'work.website_url' => 'nullable|url',
            'work.video_url' => 'nullable|url',
            'work.enabled' => 'boolean',
            'sort' => 'integer',
            'specialties.*.rate' => 'integer'
        ];

        if (!$this->work->hasMedia()) $rules['image'] = 'required|image|max:1024';

        return $rules;
    }


    public function mount($groupId, $languageId)
    {
        if ($groupId) {
            $this->work = Work::firstOrNew(['group_id' => $groupId, 'language_id' => $languageId]);

        } else {
            $this->work = new Work();
        }

        if ($this->work->sort) {
            $this->max = Work::max('sort');
            $this->sort = $this->work->sort;
        } else {
            $this->max = Work::max('sort') + 1;
            $this->sort = $this->max;
        }

        if ($this->work->enabled == null) $this->work->enabled = false;

        foreach ($this->work->articles()->orderBy('sort')->get() as $item) {

            switch ($item['type']) {

                case 'text':
                    $this->blocks[] = [
                        'id' => $item->id,
                        'type' => $item->type,
                        'content' => $item->content,
                        'sort' => $item->sort,
                        'enabled' => $item->enabled,
                        'edit' => false
                    ];
                    break;

                case 'photo':

                    $images = [];

                    foreach ($item->getMedia() as $media) {
                        $images[] = [
                            'caption' => $media->getCustomProperty('caption'),
                            'fullUrl' => $media->getFullUrl()
                        ];
                    }

                    $this->blocks[] = [
                        'id' => $item->id,
                        'type' => $item->type,
                        'content' => $images,
                        'sort' => $item->sort,
                        'enabled' => $item->enabled,
                        'edit' => false
                    ];
                    break;

                case 'album':
                    $images = [];

                    foreach ($item->getMedia() as $media) {
                        $images[] = [
                            'fullUrl' => $media->getFullUrl()
                        ];
                    }

                    $this->blocks[] = [
                        'id' => $item->id,
                        'type' => $item->type,
                        'content' => $images,
                        'sort' => $item->sort,
                        'enabled' => $item->enabled,
                        'edit' => false
                    ];
                    break;
            }


        }

        $this->specialties = Specialty::get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'color' => $item->color,
                'rate' => 0
            ];
        });

        $this->work->language_id = $this->languageId;
        $this->work->group_id = $this->groupId;
    }

    public function render()
    {
        return view('livewire.work.edit');
    }


    /**
     *
     * Functions
     *
     **/

    public function setRate($rate, $id)
    {
        dd($rate, $id);
    }


    public function getUploadLabelNameProperty()
    {
        return $this->work->hasMedia() ? '變更圖檔' : $this->uploadLabel;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        // 重新排序

        if ($this->work->sort) {

            if ($this->work->sort < $this->sort) {
                Work::where('sort', '<=', $this->sort)->where('sort', '>', $this->work->sort)->decrement('sort');
            } elseif ($this->work->sort > $this->sort) {
                Work::where('sort', '>=', $this->sort)->where('sort', '<', $this->work->sort)->increment('sort');
            }

        } else {
            Work::where('sort', '>=', $this->sort)->increment('sort');
        }

        $this->work->sort = $this->sort;
        $this->work->save();

        // 有上傳/更新圖檔
        if ($this->image) {
            $path = $this->image->store('images');

            $image = getimagesize(storage_path('app/' . $path));
            $width = $image[0];
            $height = $image[1];

            // 刪掉原本的圖檔
            $this->work->clearMediaCollection();

            $this->work->addMediaFromDisk($path)
                ->withCustomProperties(['width' => $width, 'height' => $height])
                ->toMediaCollection();
        }

        $this->reset('image');

        $this->updateBlocks();

        $this->showAlert = true;
    }

    /**
     * @return mixed
     *
     * TODO 抓 youtube id，改成到輸出 api 時處理
     */
    public function getYoutubeIdFromUrl()
    {
        parse_str(parse_url($this->videoUrl, PHP_URL_QUERY), $my_array_of_vars);
        return $my_array_of_vars['v'];
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

    public function resortingBlocks()
    {
        $this->blocks = array_values(Arr::sort($this->blocks, function ($value) {
            return $value['sort'];
        }));
    }

    /****************************
     *
     * **** 按下 新增區塊 按鈕 *****
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

    /****************************
     *
     * *********  END  **********
     *
     ****************************/

    /**
     * 按下 編輯區塊 按鈕
     *
     * 因為可能是剛新加的 block，還沒存進資料庫，所以無法用 id，只能用 sort 判斷
     * @param $sort Block 排序
     *
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

    public function editTextBlock($block)
    {
        $this->blockEditorType = 'text';
        $this->blockEditorTextContent = $block['content'];
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function editorUpdated($block)
    {
//        substr($content, 5, -6)

//        if ($this->blockEditorSort) dd($this->blockEditorSort);

        $this->showBlockEditor = false;

        $this->blocks[] = [
            'type' => $block['type'],
            'content' => $block['content'],
            'sort' => count($this->blocks) + 1,
            'edit' => false
        ];
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

    public function editPhotoBlock($block)
    {
        $this->blockEditorType = 'photo';
        $this->blockEditorModel = Block::find($block['id']);
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function editAlbumBlock($block)
    {
        $this->blockEditorType = 'album';
        $this->blockEditorModel = Block::find($block['id']);
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function alertDone()
    {
        $this->showAlert = false;
    }

    public function ratingUpdated()
    {
//        dd($data);
    }

    private function updateBlocks()
    {
        $ids = [];
        foreach ($this->blocks as $item) {

            switch ($item['type']) {

                case 'text':
                    $ids[] = $this->updateTextBlock($item);
                    break;

                case 'photo':
                    $ids[] = $this->updatePhotoBlock($item);
                    break;

                case 'album':
                    break;
            }
        }

        // 刪掉已移除的區塊
        $this->work->articles()->whereNotIn('id', $ids)->delete();
    }

    /**
     * 儲存 Html 區塊修改
     * @param $item
     * @return int|mixed
     */
    private function updateTextBlock($item)
    {
        if (isset($item['id'])) {
            Block::where('id', $item['id'])->update([
                'type' => $item['type'],
                'content' => $item['content'],
                'sort' => $item['sort'],
                'enabled' => $item['sort']
            ]);


            return $item['id'];

        } else {
            $block = new Block([
                'type' => $item['type'],
                'content' => $item['content'],
                'sort' => $item['sort'],
                'enabled' => $item['sort']
            ]);

            $this->work->articles()->save($block);

            return $block->id;
        }
    }

    /**
     * 儲存 photo 區塊修改
     * @param $item
     * @return mixed
     */
    private function updatePhotoBlock($item)
    {
        $block = Block::find($item['id']);
        $block->sort = $item['sort'];
        $this->work->articles()->save($block);
        return $item['id'];
    }
}