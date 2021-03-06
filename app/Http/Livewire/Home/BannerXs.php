<?php

namespace App\Http\Livewire\Home;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class BannerXs extends Component
{
    use WithFileUploads;

    public Setting $setting;
    public $image;
    public $iteration = 0; // for file input cleaning file name
    public bool $finish = false;
    public $uploadLabel = '上傳圖檔';

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 5MB',
    ];

    protected $rules = [
        'image' => 'required|image|max:6000'
    ];

    public function mount()
    {
        $this->setting = Setting::where('key', 'index_banner_xs')->first();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetImage()
    {
        $this->reset('image');
        $this->iteration++;
    }

    public function save()
    {
        $this->validate();

        $path = $this->image->store('images');

        $image = getimagesize(storage_path('app/' . $path));
        $width = $image[0];
        $height = $image[1];

        // 刪掉原本的圖檔
        $this->setting->clearMediaCollection();

        $this->setting->addMediaFromDisk($path)
            ->withCustomProperties(['width' => $width, 'height' => $height])
            ->toMediaCollection();

        $this->finish = true;
    }

    public function delete()
    {
        $this->setting->clearMediaCollection();
    }


    public function render()
    {
        return view('livewire.home.banner-xs');
    }
}
