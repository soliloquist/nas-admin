<?php

namespace App\Http\Livewire\Team;

use App\Models\Team;
use Livewire\Component;

class Edit extends Component
{
    public Team $team;
    public $max;
    public $sort;
    public bool $finish = false;

    protected $rules = [
        'team.title' => 'required|string',
        'sort' => 'integer',
        'team.enabled' => 'boolean'
    ];

    protected $validationAttributes = [
        'team.title' => '名稱'
    ];

    public function mount(Team $team)
    {
        $this->team = $team;

        if($this->team->sort) {
            $this->max = Team::max('sort');
            $this->sort = $this->team->sort;
        } else {
            $this->max = Team::max('sort') + 1;
            $this->sort = $this->max;
        }

        if ($this->team->enabled == null) $this->team->enabled = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        // 重新排序

        if ($this->team->sort) {

            if ($this->team->sort < $this->sort) {
                Team::where('sort', '<=', $this->sort)->where('sort', '>', $this->team->sort)->decrement('sort');
            } elseif ($this->team->sort > $this->sort) {
                Team::where('sort', '>=', $this->sort)->where('sort', '<', $this->team->sort)->increment('sort');
            }

        } else {
            Team::where('sort', '>=', $this->sort)->increment('sort');
        }

        $this->team->sort = $this->sort;
        $this->team->save();

        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.team.edit');
    }
}
