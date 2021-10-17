<?php

namespace App\Http\Livewire\Component\Modal;

use Livewire\Component;

class Alert extends Component
{
    public $confirmBtnText = 'Done';

    public function onClickConfirm()
    {
        $this->emit('ALERT_DONE');
    }

    public function render()
    {
        return view('livewire.component.modal.alert');
    }
}
