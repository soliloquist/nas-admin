<?php

namespace App\Http\Livewire\Business;

use App\Models\Business;
use App\Models\Language;
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

    public Business $business;

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

        $this->business = Business::where('group_id', $groupId)->first();
        $this->max = Business::groupBy('group_id')->get()->count();
        $this->sort = $this->business->sort;
        $this->slug = $this->business->slug;


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
        if ($this->business->sort == $value) {
            $this->sortChanged = false;
        } else {
            $this->sortChanged = true;
        }
    }

    public function updatedSlug($value)
    {
        if ($this->business->slug == $value) {
            $this->slugChanged = false;
        } else {
            $this->slugChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.business.group');
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }

    public function saveSort()
    {
        if ($this->business->sort < $this->sort) {
            Business::where('group_id', '!=', $this->business->group_id)->where('sort', '<=', $this->sort)->where('sort', '>', $this->business->sort)->decrement('sort');
        } elseif ($this->business->sort > $this->sort) {
            Business::where('group_id', '!=', $this->business->group_id)->where('sort', '>=', $this->sort)->where('sort', '<', $this->business->sort)->increment('sort');
        }

        Business::where('group_id', $this->groupId)->update(['sort' => $this->sort]);

        $this->sortChanged = false;
    }

    public function saveSlug()
    {
        Business::where('group_id', $this->groupId)->update(['slug' => $this->slug]);

        $this->slugChanged = false;
    }
}
