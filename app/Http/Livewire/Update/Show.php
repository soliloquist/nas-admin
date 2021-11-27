<?php

namespace App\Http\Livewire\Update;

use App\Models\Update;
use Livewire\Component;

class Show extends Component
{
    public Update $update;

    public function mount($groupId, $languageId)
    {
        $update = Update::where('group_id', $groupId)->where('language_id', $languageId)->first();

        $this->update = $update ?? new Update();
    }

    public function render()
    {
        return view('livewire.update.show');
    }
}
