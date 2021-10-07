<?php

namespace App\Http\Livewire\Specialty;

use App\Models\Specialty;
use Livewire\Component;

class Edit extends Component
{
    public Specialty $specialty;

    public bool $finish = false;

    protected $rules = [
        'specialty.name' => 'required|string',
        'specialty.color' => 'required'
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

        $this->specialty->save();
        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.specialty.edit');
    }
}
