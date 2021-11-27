<?php

namespace App\Http\Livewire\Update;

use App\Models\Language;
use App\Models\Update;
use Carbon\Carbon;
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
    public $dateChanged = false;

    // date
    public $year;
    public $month;
    public $date;

    public $oldYear;
    public $oldMonth;
    public $oldDate;

    public Update $update;

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

        $this->update = Update::where('group_id', $groupId)->first();
        $this->max = Update::groupBy('group_id')->get()->count();
        $this->sort = $this->update->sort;
        $this->slug = $this->update->slug;

        if ($this->update->date) {
            $this->year = Carbon::parse($this->update->date)->format('Y');
            $this->month = Carbon::parse($this->update->date)->format('m');
            $this->date = Carbon::parse($this->update->date)->format('d');
        } else {
            $this->year = Carbon::now()->format('Y');
            $this->month = Carbon::now()->format('m');
            $this->date = Carbon::now()->format('d');
        }

        $this->oldDate = $this->date;
        $this->oldMonth = $this->month;
        $this->oldYear = $this->year;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->sort > $this->max) {
            $this->sort = $this->max;
        } elseif ($this->sort < 1) {
            $this->sort = 1;
        }

        if ($this->oldYear == $this->year && $this->month == $this->oldMonth && $this->oldDate == $this->date) {
            $this->dateChanged = false;
        } else {
            $this->dateChanged = true;
        }
    }

    public function updatedSort($value)
    {
        if ($this->update->sort == $value) {
            $this->sortChanged = false;
        }  else {
            $this->sortChanged = true;
        }
    }

    public function updatedSlug($value)
    {
        if ($this->update->slug == $value) {
            $this->slugChanged = false;
        } else {
            $this->slugChanged = true;
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

    public function saveSort()
    {
        if ($this->update->sort < $this->sort) {
            Update::where('group_id', '!=', $this->update->group_id)->where('sort', '<=', $this->sort)->where('sort', '>', $this->update->sort)->decrement('sort');
        } elseif ($this->update->sort > $this->sort) {
            Update::where('group_id', '!=', $this->update->group_id)->where('sort', '>=', $this->sort)->where('sort', '<', $this->update->sort)->increment('sort');
        }

        Update::where('group_id', $this->groupId)->update(['sort' => $this->sort]);

        $this->sortChanged = false;
    }

    public function saveSlug()
    {
        Update::where('group_id', $this->groupId)->update(['slug' => $this->slug]);

        $this->slugChanged = false;
    }

    public function saveDate()
    {
        $year = $this->year. '-01-01';
        $date = $this->year. '-'. $this->month . '-' . $this->date;

        Update::where('group_id', $this->groupId)->update(['date' => $date, 'year' => $year]);

        $this->dateChanged = false;
    }
}
