<?php

namespace App\Http\Livewire\Update;

use App\Models\Block;
use App\Models\Update;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Update $update;
    public $image;
    public $iteration = 0; // for file input cleaning file name
    public $max;
    public $sort;
    public $uploadLabel = '上傳圖檔';
    public $groupId;
    public $languageId;
    public $videoUrl;
    public $saveButtonText = 'save';

    // date
    public $year;
    public $month;
    public $date;

    public $showAlert = false;

    // Block 編輯相關
    public $showBlockEditor = false;
    public $blockEditorType = 'text'; // text|photo|album
    public $blockEditorId = null;
    public $blockEditorTextContent = null;
    public $blockEditorSort = null;
    public $blockEditorModel = null;

    public $blocks = [];

    protected $listeners = [
        'EDITOR_UPDATED' => 'editorUpdated',
        'PHOTO_BLOCK_CREATED' => 'photoBlockCreated',
        'PHOTO_BLOCK_UPDATED' => 'photoBlockUpdated',
        'ALBUM_BLOCK_CREATED' => 'photoBlockCreated',
        'ALBUM_BLOCK_UPDATED' => 'photoBlockUpdated',
        'ALERT_DONE' => 'alertDone'
    ];

    protected $validationAttributes = [
        'update.title' => '名稱',
        'update.slug' => '網址',
    ];

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 5MB',
        'year.required' => '請填入年份',
        'year.date_format' => '年份格式有誤',
        'month.required' => '請填入月份',
        'month.date_format' => '月份格式有誤',
        'date.required' => '請填入日期',
        'date.date_format' => '日期格式有誤',
    ];

    protected function rules()
    {
        $rules = [
            'update.language_id' => 'required|integer',
            'update.group_id' => 'required|uuid',
            'update.slug' => 'required',
            'update.title' => 'required|string',
            'update.enabled' => 'boolean',
            'sort' => 'integer',
            'year' => 'required|date_format:Y',
            'month' => 'required|date_format:m',
            'date' => 'required|date_format:d',
        ];

        if (!$this->update->hasMedia()) $rules['image'] = 'required|image|max:6000';

        return $rules;
    }


    public function mount($groupId, $languageId)
    {
        if ($groupId) {
            $this->update = Update::firstOrNew(['group_id' => $groupId, 'language_id' => $languageId]);


        } else {
            $this->update = new Update();
        }

        if ($this->update->enabled == null) $this->update->enabled = false;

        if ($this->update->date) {
            $this->year = Carbon::parse($this->update->date)->format('Y');
            $this->month = Carbon::parse($this->update->date)->format('m');
            $this->date = Carbon::parse($this->update->date)->format('d');
        } else {
            $this->year = Carbon::now()->format('Y');
            $this->month = Carbon::now()->format('m');
            $this->date = Carbon::now()->format('d');
        }

        foreach ($this->update->articles()->orderBy('sort')->get() as $item) {

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

        $this->update->language_id = $this->languageId;
        $this->update->group_id = $this->groupId;
    }

    public function render()
    {
        return view('livewire.update.edit');
    }


    /**
     *
     * Functions
     *
     **/


    public function getUploadLabelNameProperty()
    {
        return $this->update->hasMedia() ? '變更圖檔' : $this->uploadLabel;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        // 重新排序

        if ($this->update->sort) {

            // 修改

            if ($this->update->sort < $this->sort) {
                Update::where('group_id', '!=', $this->update->group_id)->where('sort', '<=', $this->sort)->where('sort', '>', $this->update->sort)->decrement('sort');
            } elseif ($this->update->sort > $this->sort) {
                Update::where('group_id', '!=', $this->update->group_id)->where('sort', '>=', $this->sort)->where('sort', '<', $this->update->sort)->increment('sort');
            }

            Update::where('group_id', $this->update->group_id)->update(['sort' => $this->sort]);

        } else {
            Update::where('sort', '>=', $this->sort)->increment('sort');
        }

        // 日期處理
        $this->update->year = $this->year. '-01-01';
        $this->update->date = $this->year. '-'. $this->month . '-' . $this->date;

        $this->update->sort = $this->sort;
        $this->update->save();

        // 有上傳/更新圖檔
        if ($this->image) {
            $path = $this->image->store('images');

            $image = getimagesize(storage_path('app/' . $path));
            $width = $image[0];
            $height = $image[1];

            // 刪掉原本的圖檔
            $this->update->clearMediaCollection();

            $this->update->addMediaFromDisk($path)
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
        $this->update->articles()->whereNotIn('id', $ids)->delete();
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

            $this->update->articles()->save($block);

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
        $this->update->articles()->save($block);
        return $item['id'];
    }
}
