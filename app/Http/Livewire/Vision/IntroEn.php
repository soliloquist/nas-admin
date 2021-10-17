<?php

namespace App\Http\Livewire\Vision;

use App\Models\Setting;
use Livewire\Component;

class IntroEn extends Component
{
    public $processing = false;
    public $finish = false;
    public Setting $setting;

    protected $rules = [
        'setting.value' => 'nullable|string'
    ];

    public function mount()
    {
        $this->setting = Setting::where('key', 'vision_intro_en')->first();
    }

    public function save()
    {
        $this->setting->save();
        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.vision.intro-en');
    }
}
