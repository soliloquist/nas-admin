<?php

namespace App\Http\Livewire\Component\Modal;

use Livewire\Component;

class Created extends Component
{
    public $cancelBtnText = '回列表頁';
    public $confirmBtnText = '新增下一筆';
    public $title = '新增完成';

    public function onClickConfirm()
    {
        $this->emit('CREATED_CONFIRM');
    }

    public function onClickCancel()
    {
        $this->emit('CREATED_CANCEL');
    }

    public function render()
    {
        return view('livewire.component.modal.created');
    }
}
