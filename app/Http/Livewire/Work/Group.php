<?php

namespace App\Http\Livewire\Work;

use App\Models\Language;
use App\Models\Work;
use Illuminate\Support\Str;
use Livewire\Component;

class Group extends Component
{
    public $groupId; //uuid
    public $languageId;
    public $languages;
    public $tab;
    public $sort;
    public $max;
    public $sortChanged = false;
    public $slug;
    public $slugChanged = false;

    public Work $work;

    protected $validationAttributes = [
        'sort' => '排序',
        'slug' => '網址'
    ];

    protected $rules = [
        'sort' => 'required|int',
        'slug' => 'required'
    ];

    public function mount($groupId, $languageId)
    {
        $this->groupId = $groupId;
        $this->languageId = $languageId;
        $this->languages = Language::all();
        $this->tab = $this->languages[0]->id;

        $this->work = Work::where('group_id', $groupId)->first();
        $this->max = Work::groupBy('group_id')->get()->count();
        $this->sort = $this->work->sort;
        $this->slug = $this->work->slug;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($this->sort > $this->max) {
            $this->sort = $this->max;
        } elseif ($this->sort < 1) {
            $this->sort = 1;
        }
    }

    public function updatedSort($value)
    {
        if ($this->work->sort == $value) {
            $this->sortChanged = false;
        }  else {
            $this->sortChanged = true;
        }
    }

    public function updatedSlug($value)
    {
        if ($this->work->slug == $value) {
            $this->slugChanged = false;
        } else {
            $this->slugChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.work.group');
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }

    public function saveSort()
    {
        if ($this->work->sort < $this->sort) {
            Work::where('group_id', '!=', $this->work->group_id)->where('sort', '<=', $this->sort)->where('sort', '>', $this->work->sort)->decrement('sort');
        } elseif ($this->work->sort > $this->sort) {
            Work::where('group_id', '!=', $this->work->group_id)->where('sort', '>=', $this->sort)->where('sort', '<', $this->work->sort)->increment('sort');
        }

        Work::where('group_id', $this->groupId)->update(['sort' => $this->sort]);

        $this->sortChanged = false;
    }

    public function saveSlug()
    {
        Work::where('group_id', $this->groupId)->update(['slug' => $this->slug]);

        $this->slugChanged = false;
    }
}
