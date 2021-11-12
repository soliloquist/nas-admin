<?php

namespace App\Http\Livewire\ContactType;

use App\Models\ContactType;
use Livewire\Component;

class Edit extends Component
{
    public ContactType $contactType;
    public bool $finish = false;

    protected $validationAttributes = [
        'contactType.title' => '類型名稱'
    ];

    protected $rules = [
        'contactType.title' => 'required|string'
    ];

    public function mount(ContactType $contactType)
    {
        $this->contactType = $contactType;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();
        $this->contactType->save();
        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.contact-type.edit');
    }
}
