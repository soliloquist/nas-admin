<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Enabled extends Component
{
    public $changed = false;
    public Model $item;
    public $enabled;

    protected $rules = [
        'enabled' => 'boolean'
    ];

    public function mount(Model $item)
    {
        $this->item = $item;
        $this->enabled = $item->enabled;
    }

    public function render()
    {
        return view('livewire.component.editor.enabled');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->item->enabled == $this->enabled) {
            $this->changed = false;
        } else {
            $this->changed = true;
        }
    }

    public function save()
    {
        $this->item->enabled = $this->enabled;
        $this->item->save();

        $this->changed = false;
    }
}
