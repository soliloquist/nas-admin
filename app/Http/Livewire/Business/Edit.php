<?php

namespace App\Http\Livewire\Business;

use App\Models\Business;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Business $business;
    public $image;
    public $iteration = 0; // for file input cleaning file name
    public $max;
    public $sort;
    public $uploadLabel = '上傳圖檔';
    public $groupId;
    public $languageId;
    public $videoUrl;

    protected $validationAttributes = [
        'business.title' => '名稱',
        'business.slug' => '網址',
    ];

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 1MB',
    ];

    protected function rules()
    {
        $rules = [
            'business.language_id' => 'required|integer',
            'business.group_id' => 'required|uuid',
            'business.slug' => 'required',
            'business.title' => 'required|string',
            'business.website_url' => 'url',
            'business.enabled' => 'boolean',
            'sort' => 'integer',
            'videoUrl' => 'url',
        ];

        if (!$this->business->hasMedia()) $rules['image'] = 'required|image|max:1024';

        return $rules;
    }

    public function mount(Business $business)
    {
        $this->business = $business;

        if($this->business->sort) {
            $this->max = Business::max('sort');
            $this->sort = $this->business->sort;
        } else {
            $this->max = Business::max('sort') + 1;
            $this->sort = $this->max;
        }

        if ($this->business->enabled == null) $this->business->enabled = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $this->business->video_url = $this->getYoutubeIdFromUrl();

        // 重新排序

        if ($this->business->sort) {

            if ($this->business->sort < $this->sort) {
                Business::where('sort', '<=', $this->sort)->where('sort', '>', $this->business->sort)->decrement('sort');
            } elseif ($this->business->sort > $this->sort) {
                Business::where('sort', '>=', $this->sort)->where('sort', '<', $this->business->sort)->increment('sort');
            }

        } else {
            Business::where('sort', '>=', $this->sort)->increment('sort');
        }

        $this->business->sort = $this->sort;
        $this->business->save();

        // 有上傳/更新圖檔
        if ($this->image) {
            $path = $this->image->store('images');

            $image = getimagesize(storage_path('app/' . $path));
            $width = $image[0];
            $height = $image[1];

            // 刪掉原本的圖檔
            $this->business->clearMediaCollection();

            $this->business->addMediaFromDisk($path)
                ->withCustomProperties(['width' => $width, 'height' => $height])
                ->toMediaCollection();
        }
    }

    public function render()
    {
        return view('livewire.business.edit');
    }

    public function getYoutubeIdFromUrl()
    {
        parse_str( parse_url( $this->videoUrl, PHP_URL_QUERY ), $my_array_of_vars );
        return $my_array_of_vars['v'];
    }
}
