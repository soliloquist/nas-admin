<?php

namespace App\Http\Livewire\Work;

use App\Models\Language;
use App\Models\Work;
use Illuminate\Support\Str;
use Livewire\Component;

class Group extends Component
{
    public $groupId; //uuid
    public $languages;
    public $tab;
    public $sort;
    public $max;
    public $slug;

    protected $validationAttributes = [
        'sort' => '排序',
        'slug' => '網址'
    ];

    protected $rules = [
        'sort' => 'required|int',
        'slug' => 'required'
    ];

    public function mount($groupId = null)
    {
        $this->groupId = $groupId ?? (string) Str::orderedUuid();
        $this->languages = Language::all();
        $this->tab = $this->languages[0]->id;

        if ($groupId) {
            $this->max = Work::groupBy('group_id')->get()->count();
            $this->sort = Work::where('group_id', $groupId)->value('sort');

            $this->slug = Work::where('group_id', $groupId)->value('slug');
        } else {
            $this->max = Work::groupBy('group_id')->get()->count() + 1;
            $this->sort = $this->max;
        }
    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
        if ($this->sort > $this->max) {
            $this->sort = $this->max;
        } elseif ($this->sort < 1) {
            $this->sort = 1;
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
}
