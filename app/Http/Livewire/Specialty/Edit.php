<?php

namespace App\Http\Livewire\Specialty;

use App\Models\Specialty;
use Livewire\Component;

class Edit extends Component
{
    public Specialty $specialty;

    public bool $finish = false;
    public $sort;
    public $max;

    protected $rules = [
        'specialty.name' => 'required|string',
        'specialty.color' => 'required',
        'sort' => 'integer'
    ];

    protected $validationAttributes = [
        'specialty.name' => '名稱'
    ];

    protected $messages = [
        'specialty.color.required' => '請設定顏色',
    ];

    protected $listeners = [
        'setColor' => 'setColor',
    ];

    public function mount(Specialty $specialty)
    {
        $this->specialty = $specialty;

        if (!$this->specialty->color) $this->specialty->color = '#000000';

        if($this->specialty->sort) {
            $this->max = Specialty::max('sort');
            $this->sort = $this->specialty->sort;
        } else {
            $this->max = Specialty::max('sort') + 1;
            $this->sort = $this->max;
        }
    }

    public function setColor($value)
    {
        $this->specialty->color = $value;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        if ($this->specialty->sort) {

            if ($this->specialty->sort < $this->sort) {
                Specialty::where('sort', '<=', $this->sort)->where('sort', '>', $this->specialty->sort)->decrement('sort');
            } elseif ($this->specialty->sort > $this->sort) {
                Specialty::where('sort', '>=', $this->sort)->where('sort', '<', $this->specialty->sort)->increment('sort');
            }

        } else {
            Specialty::where('sort', '>=', $this->sort)->increment('sort');
        }

        $this->specialty->sort = $this->sort;

        $this->specialty->save();
        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.specialty.edit');
    }
}
