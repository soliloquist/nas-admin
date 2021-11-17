<?php

namespace App\Http\Livewire\Tag;

use App\Models\Tag;
use Livewire\Component;

class Edit extends Component
{
    public Tag $tag;
    public $max;
    public $sort;
    public $type = 'create';
    public bool $finish = false;

    protected $rules = [
        'tag.name' => 'required|string',
        'sort' => 'integer',
    ];

    protected $validationAttributes = [
        'tag.name' => '名稱'
    ];

    public function mount(Tag $tag)
    {
        $this->tag = $tag;

        if ($this->tag->id) $this->type = 'edit';

        if($this->tag->sort) {
            $this->max = Tag::max('sort');
            $this->sort = $this->tag->sort;
        } else {
            $this->max = Tag::max('sort') + 1;
            $this->sort = $this->max;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        // 重新排序

        if ($this->tag->sort) {

            if ($this->tag->sort < $this->sort) {
                Tag::where('sort', '<=', $this->sort)->where('sort', '>', $this->tag->sort)->decrement('sort');
            } elseif ($this->tag->sort > $this->sort) {
                Tag::where('sort', '>=', $this->sort)->where('sort', '<', $this->tag->sort)->increment('sort');
            }

        } else {
            Tag::where('sort', '>=', $this->sort)->increment('sort');
        }

        $this->tag->sort = $this->sort;
        $this->tag->save();

        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.tag.edit');
    }
}
