<?php

namespace App\Http\Livewire\Business;

use App\Models\Language;
use Illuminate\Support\Str;
use Livewire\Component;

class Group extends Component
{
    public $groupId; //uuid
    public $languages;
    public $tab;

    public function mount()
    {
        $this->groupId = (string) Str::orderedUuid();
        $this->languages = Language::all();
        $this->tab = $this->languages[0]->id;
    }

    public function render()
    {
        return view('livewire.business.group');
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }
}
