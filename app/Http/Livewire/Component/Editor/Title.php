<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Title extends Component
{
    public $title;
    public $changed = false;
    public Model $item;

    protected $validationAttributes = [
        'title' => '名稱',
    ];

    protected $rules = [
        'title' => 'required|string'
    ];

    public function mount(Model $item)
    {
        $this->item = $item;
        $this->title = $item->title;
    }

    public function render()
    {
        return view('livewire.component.editor.title');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->item->title == $this->title) {
            $this->changed = false;
        } else {
            $this->changed = true;
        }
    }

    public function save()
    {
        $this->item->title = $this->title;
        $this->item->save();

        $this->changed = false;
    }
}
