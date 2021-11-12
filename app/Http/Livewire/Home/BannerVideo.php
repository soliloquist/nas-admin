<?php

namespace App\Http\Livewire\Home;

use App\Models\Setting;
use Livewire\Component;

class BannerVideo extends Component
{
    public Setting $setting;
    public bool $finish = false;

    protected $rules = [
        'setting.value' => 'nullable|url'
    ];

    protected $messages = [
        'setting.value.url' => '請填入正確網址',
    ];

    public function mount()
    {
        $this->setting = Setting::where('key', 'index_banner_video')->first();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        if (!$this->setting->value) $this->setting->value = null;
        $this->setting->save();
        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.home.banner-video');
    }
}
