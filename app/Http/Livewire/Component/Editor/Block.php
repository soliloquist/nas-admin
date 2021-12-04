<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Livewire\Component;

class Block extends Component
{
    public $changed = false;
    public Model $item;
    public $blocks = [];

    public $showBlockEditor = false;
    public $blockEditorType = 'text'; // text|photo|album
    public $blockEditorId = null;
    public $blockEditorTextContent = null;
    public $blockEditorSort = null;
    public $blockEditorModel = null;

    protected $listeners = [
        'EDITOR_CREATED' => 'editorCreated',
        'EDITOR_UPDATED' => 'editorUpdated',
        'PHOTO_BLOCK_CREATED' => 'photoBlockCreated',
        'PHOTO_BLOCK_UPDATED' => 'photoBlockUpdated',
        'ALBUM_BLOCK_CREATED' => 'albumBlockCreated',
        'ALBUM_BLOCK_UPDATED' => 'albumBlockUpdated',
        'ALERT_DONE' => 'alertDone',
    ];

    public function mount(Model $item)
    {
        $this->item = $item;

        $this->setBlocks();
    }

    public function render()
    {
        return view('livewire.component.editor.block');
    }

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
        $this->blockEditorModel = \App\Models\Block::find($block['id']);
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function editorCreated($blockId)
    {
        $block = \App\Models\Block::find($blockId);

        $block->sort = count($this->blocks) + 1;
        $block->save();

        $this->item->articles()->save($block);

        $this->setBlocks();

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

        $block = \App\Models\Block::find($blockId);

        foreach ($block->getMedia() as $media) {
            $images[] = [
                'caption' => $media->getCustomProperty('caption'),
                'fullUrl' => $media->getFullUrl()
            ];
        }

        $block->sort = count($this->blocks) + 1;
        $block->save();

        $this->item->articles()->save($block);

        $this->setBlocks();

        $this->showBlockEditor = false;
    }

    public function editPhotoBlock($block)
    {
        $this->blockEditorType = 'photo';
        $this->blockEditorModel = \App\Models\Block::find($block['id']);
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function photoBlockUpdated($blockId)
    {
        $images = [];

        foreach (\App\Models\Block::find($blockId)->getMedia() as $media) {
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
        $this->blockEditorModel = \App\Models\Block::find($block['id']);
        $this->blockEditorSort = $block['sort'];
        $this->showBlockEditor = true;
    }

    public function albumBlockCreated($blockId)
    {
        $images = [];

        $block = \App\Models\Block::find($blockId);

        foreach ($block->getMedia() as $media) {
            $images[] = [
                'fullUrl' => $media->getFullUrl()
            ];
        }

        $block->sort = count($this->blocks) + 1;
        $block->save();

        $this->item->articles()->save($block);

        $this->setBlocks();

        $this->showBlockEditor = false;
    }

    public function albumBlockUpdated($blockId)
    {
        $images = [];

        foreach (\App\Models\Block::find($blockId)->getMedia() as $media) {
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
    public function onClickEditBlock($id)
    {
        foreach ($this->blocks as $key => $value) {
            if ($value['id'] == $id) {

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

    public function onClickRemoveBlock($id)
    {
        foreach ($this->blocks as $key => $value) {
            if ($value['id'] == $id) {

                $block = \App\Models\Block::find($id);

                \App\Models\Block::where('article_id', $block->article_id)
                    ->where('article_type', $block->article_type)
                    ->where('sort', '>', $block->sort)
                    ->decrement('sort');

                $block->delete();

                unset($this->blocks[$key]);
            }
        }
    }

    public function sortDecrease($id)
    {
        $sort = 1;
        foreach ($this->blocks as $key => $item) {

            if ($item['id'] == $id) {
                $sort = $item['sort'];
                $this->blocks[$key]['sort']--;
            }

        }

        foreach ($this->blocks as $key => $item) {

            if ($item['sort'] == $sort - 1 && $item['id'] != $id) {
                $this->blocks[$key]['sort']++;
            }
        }
        $this->resortingBlocks();
    }

    public function sortIncrease($id)
    {
        $sort = 1;
        foreach ($this->blocks as $key => $item) {

            if ($item['id'] == $id) {
                $this->blocks[$key]['sort']++;
            }
        }

        foreach ($this->blocks as $key => $item) {

            if ($item['sort'] == $sort + 1 && $item['id'] != $id) {
                $this->blocks[$key]['sort']--;
            }
        }

        $this->resortingBlocks();
    }

    public function editorUpdated($blockId)
    {
        $block = \App\Models\Block::find($blockId);

        foreach ($this->blocks as $key => $value) {
            if ($value['type'] == 'text' && $value['id'] == $blockId) {
                $this->blocks[$key]['content'] = $block->content;
            }
        }

        $this->showBlockEditor = false;
    }

    public function resortingBlocks()
    {
        foreach ($this->blocks as $item) {

            $block = \App\Models\Block::find($item['id']);
            $block->sort = $item['sort'];
            $block->save();
        }

        $this->blocks = array_values(Arr::sort($this->blocks, function ($value) {
            return $value['sort'];
        }));
    }


    private function setBlocks()
    {
        $this->blocks = [];
        foreach ($this->item->articles()->orderBy('sort')->get() as $item) {

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
    }
}
