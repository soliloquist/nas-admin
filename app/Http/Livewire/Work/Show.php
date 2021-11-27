<?php

namespace App\Http\Livewire\Work;

use App\Models\Work;
use Livewire\Component;

class Show extends Component
{
    public Work $work;

    public function mount($groupId, $languageId)
    {
        $work = Work::where('group_id', $groupId)->where('language_id', $languageId)->first();

        $this->work = $work ?? new Work();
    }

    public function render()
    {
        return view('livewire.work.show');
    }
}
