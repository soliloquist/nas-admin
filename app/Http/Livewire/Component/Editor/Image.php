<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithFileUploads;

class Image extends Component
{
    use WithFileUploads;

    public $changed = false;
    public Model $item;
    public $image;
    public $iteration = 0; // for file input cleaning file name

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 5MB',
    ];

    protected $rules = [
        'image' => 'required|image|max:6000',
    ];

    public function mount(Model $item)
    {
        $this->item = $item;
    }

    public function render()
    {
        return view('livewire.component.editor.image');
    }

    public function getUploadLabelNameProperty()
    {
        return $this->item->hasMedia() ? '變更圖檔' : '上傳圖檔';
    }

    public function resetImage()
    {
        $this->reset('image');
        $this->iteration++;

        $this->changed = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        $this->changed = true;
    }

    public function save()
    {
        if ($this->image) {
            $path = $this->image->store('images');

            $image = getimagesize(storage_path('app/' . $path));
            $width = $image[0];
            $height = $image[1];

            // 刪掉原本的圖檔
            $this->item->clearMediaCollection();

            $this->item->addMediaFromDisk($path)
                ->withCustomProperties(['width' => $width, 'height' => $height])
                ->toMediaCollection();
        }

        $this->reset('image');
        $this->changed = false;
    }
}
