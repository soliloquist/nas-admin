<?php

namespace App\Http\Livewire\Component\Upload;

use Livewire\Component;

class Image extends Component
{
    public $image;

    public function mount()
    {

    }

    public function click()
    {
        $this->image = 999;
    }
    public function render()
    {
        return view('livewire.component.upload.image');
    }
}
