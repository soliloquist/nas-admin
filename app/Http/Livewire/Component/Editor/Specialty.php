<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Specialty extends Component
{
    public $changed = false;
    public Model $item;
    public $specialties = [];
    public $old = [];

    protected $rules = [
        'specialties.*.rate' => 'integer',
    ];

    public function mount(Model $item)
    {
        $this->item = $item;

        $this->specialties = \App\Models\Specialty::get()->map(function ($item) {

            $percentage = $item->works()->where('works.id', $this->item->id)->first() ? $item->works()->where('works.id', $this->item->id)->first()->pivot->percentage : 0;

            return [
                'id' => $item->id,
                'name' => $item->name,
                'color' => $item->color,
                'rate' => $percentage
            ];
        });

        $this->old = clone($this->specialties);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->old == $this->specialties) {
            $this->changed = false;
        } else {
            $this->changed = true;
        }
    }

    public function render()
    {
        return view('livewire.component.editor.specialty');
    }

    public function setRate($rate, $id)
    {
        $this->specialties = $this->specialties->map(function ($item) use ($rate, $id) {
            if ($item['id'] == $id) $item['rate'] = $rate;
            return $item;
        });

        if ($this->old == $this->specialties) {
            $this->changed = false;
        } else {
            $this->changed = true;
        }
    }

    public function save()
    {
        $specialties = [];

        foreach ($this->specialties as $s) {
            if ($s['rate']) {
                $specialties[$s['id']] = ['percentage' => $s['rate']];
            }
        }

        $this->item->specialties()->sync($specialties);

        $this->changed = false;
    }
}
