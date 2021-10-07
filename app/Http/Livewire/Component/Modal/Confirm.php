<?php

namespace App\Http\Livewire\Component\Modal;

use Livewire\Component;

class Confirm extends Component
{
    public $confirmBtnText = 'Done';

    public function onClickConfirm()
    {
        $this->emit('confirm');
    }

    public function onClickCancel()
    {
        $this->emit('cancel');
    }

    public function render()
    {
        return view('livewire.component.modal.confirm');
    }
}
