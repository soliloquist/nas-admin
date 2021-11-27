<?php

namespace App\Http\Livewire\Business;

use App\Models\Business;
use Livewire\Component;

class Show extends Component
{
    public Business $business;

    public function mount($groupId, $languageId)
    {
        $business = Business::where('group_id', $groupId)->where('language_id', $languageId)->first();

        $this->business = $business ?? new Business();
    }
    public function render()
    {
        return view('livewire.business.show');
    }
}
