<?php

namespace App\Http\Livewire\Update;

use App\Models\Language;
use App\Models\Update;
use Illuminate\Support\Str;
use Livewire\Component;

class Group extends Component
{
    public $groupId; //uuid
    public $languages;
    public $tab;
    public $sort;
    public $max;

    protected $validationAttributes = [
        'sort' => '排序',
    ];

    protected $rules = [
        'sort' => 'required|int'
    ];

    public function mount($groupId = null)
    {
        $this->groupId = $groupId ?? (string) Str::orderedUuid();
        $this->languages = Language::all();
        $this->tab = $this->languages[0]->id;

        if ($groupId) {
            $this->max = Update::groupBy('group_id')->get()->count();
            $this->sort = Update::where('group_id', $groupId)->value('sort');
        } else {
            $this->max = Update::groupBy('group_id')->get()->count() + 1;
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
        return view('livewire.update.group');
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }
}
