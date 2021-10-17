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

    public $processing = false;

    protected $rules = [
        'content' => 'required|string',
    ];

    public function mount()
    {
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

        $this->emit('EDITOR_UPDATED', [
            'id' => $this->blockId,
            'type' => 'text',
            'content' => $this->content,
        ]);

        $this->reset('content');

        $this->processing = false;
    }
}
