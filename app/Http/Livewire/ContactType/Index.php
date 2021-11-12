<?php

namespace App\Http\Livewire\ContactType;

use App\Models\ContactType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $modal = false;
    public $selected = [];

    protected $listeners = ['confirm' => 'delete', 'cancel' => 'hideModal'];

    public function mount()
    {

    }

    public function onClickDelete($id)
    {
        $this->selected[] = $id;
        $this->modal = true;
    }

    public function delete()
    {
        ContactType::whereIn('id', $this->selected)->delete();

        $this->hideModal();
    }

    public function hideModal()
    {
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.contact-type.index', [
            'contactTypes' => ContactType::paginate(20)
        ]);
    }
}
