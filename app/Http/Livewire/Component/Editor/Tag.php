<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Tag extends Component
{
    public $changed = false;
    public Model $item;
    public $tags = [];
    public $old = [];
    public $tagOptions = [];

    protected $rules = [
        'tags' => 'array'
    ];

    public function mount(Model $item)
    {
        $this->item = $item;

        $this->tagOptions = \App\Models\Tag::all();
        $this->tags = $this->item->tags->map(function ($item) {
            return $item->id . '';
        })->toArray();
        $this->old = $this->item->tags->map(function ($item) {
            return $item->id . '';
        })->toArray();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->old == $this->tags) {
            $this->changed = false;
        } else {
            $this->changed = true;
        }
    }


    public function render()
    {
        return view('livewire.component.editor.tag');
    }

    public function save()
    {
        $this->item->tags()->sync($this->tags);

        $this->changed = false;
    }
}
