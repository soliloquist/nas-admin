<?php

namespace App\Http\Livewire;

use App\Models\Block;
use Livewire\Component;

class Trix extends Component
{
    public $blockId;
    public $content;
    public $type;
    public $editorId;
    public $block;

    public $processing = false;

    protected $rules = [
        'content' => 'required|string',
    ];

    public function mount($block)
    {
        if (!$block) {
            $this->block = new Block();
        } else {
            $this->block = $block;
            $this->content = $block->content;
        }

        $this->editorId = uniqid();
    }

    public function render()
    {
        return view('livewire.trix');
    }

    public function save()
    {
        $this->validate();

        $this->processing = true;

        $type = $this->block->id ? 'update' : 'create';

        $this->block->content = $this->content;
        $this->block->type = 'text';
        $this->block->save();

        if ($type == 'update') {
            $this->emit('EDITOR_UPDATED', $this->block->id);

        } else {
            $this->emit('EDITOR_CREATED', $this->block->id);
        }

        $this->reset('content');

        $this->processing = false;


    }
}
