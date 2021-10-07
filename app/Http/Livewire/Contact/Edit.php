<?php

namespace App\Http\Livewire\Contact;

use App\Models\Contact;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Contact $contact;
    public bool $finish = false;

    protected $validationAttributes = [
        'contact.name' => '聯絡人姓名'
    ];

    protected function rules()
    {
        return [
            'contact.name' => 'required|string',
            'contact.email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')->ignore($this->contact->id),
            ],
            'contact.phone' => 'nullable',
            'contact.note' => 'nullable',
            'contact.type' => 'required|integer'
        ];
    }

    public function mount(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();
        $this->contact->save();
        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.contact.edit');
    }
}
