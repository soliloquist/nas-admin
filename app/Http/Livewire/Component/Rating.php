<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class Rating extends Component
{
    public $rating = 0;

    public function render()
    {
        return view('livewire.component.rating');
    }
}
