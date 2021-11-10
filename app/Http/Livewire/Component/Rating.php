<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class Rating extends Component
{
    public $rating = 0;
    public $itemId;

    public function mount($itemId)
    {
        $this->itemId = $itemId;
    }

    public function updated($value)
    {
//        return $this->emit('RATING_UPDATE');
//        dd($this->rating);
    }

    public function render()
    {
        return view('livewire.component.rating');
    }
}
