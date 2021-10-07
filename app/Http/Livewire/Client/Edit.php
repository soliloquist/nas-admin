<?php

namespace App\Http\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Client $client;
    public $image;
    public $iteration = 0; // for file input cleaning file name
    public $max;
    public $sort;
    public bool $finish = false;
    public $uploadLabel = '上傳圖檔';

    protected $validationAttributes = [
        'client.name' => '名稱',
    ];

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 1MB',
    ];

    protected function rules()
    {
        $rules = [
            'client.name' => 'required|string',
            'client.link' => 'nullable|url',
            'sort' => 'integer',
            'client.enabled' => 'boolean'
        ];

        if (!$this->client->hasMedia()) $rules['image'] = 'required|image|max:1024';

        return $rules;
    }

    public function mount(Client $client)
    {
        $this->client = $client;

        if($this->client->sort) {
            $this->max = Client::max('sort');
            $this->sort = $this->client->sort;
        } else {
            $this->max = Client::max('sort') + 1;
            $this->sort = $this->max;
        }

        if ($this->client->enabled == null) $this->client->enabled = false;
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

        // 重新排序

        if ($this->client->sort) {

            if ($this->client->sort < $this->sort) {
                Client::where('sort', '<=', $this->sort)->where('sort', '>', $this->client->sort)->decrement('sort');
            } elseif ($this->client->sort > $this->sort) {
                Client::where('sort', '>=', $this->sort)->where('sort', '<', $this->client->sort)->increment('sort');
            }

        } else {
            Client::where('sort', '>=', $this->sort)->increment('sort');
        }

        $this->client->sort = $this->sort;
        $this->client->save();

        // 有上傳/更新圖檔
        if ($this->image) {
            $path = $this->image->store('images');

            $image = getimagesize(storage_path('app/' . $path));
            $width = $image[0];
            $height = $image[1];

            // 刪掉原本的圖檔
            $this->client->clearMediaCollection();

            $this->client->addMediaFromDisk($path)
                ->withCustomProperties(['width' => $width, 'height' => $height])
                ->toMediaCollection();
        }

        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.client.edit');
    }
}
