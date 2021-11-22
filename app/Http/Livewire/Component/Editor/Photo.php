<?php

namespace App\Http\Livewire\Component\Editor;

use App\Models\Block;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Photo extends Component
{
    use WithFileUploads;

    public $iteration = 0; // for file input cleaning file name
    public $uploads = [];
    public $images = [];
    public $captions = [];
    public $block;

    protected $messages = [
        'uploads.*.required' => '請上傳圖檔',
        'uploads.*.image' => '圖檔必須為 jpg,gif,png 格式',
        'uploads.*.max' => '圖檔不可超過 5MB',
    ];

    protected $rules = [
        'uploads.*' => 'image|max:6000',
        'images.*.caption' => 'nullable|string'
    ];

    public function mount($block)
    {
        if (!$block) {
            $this->block = new Block();
        } else {
            $this->block = $block;
        }

        if ($this->block->id) {

            foreach ($this->block->getMedia() as $media) {
                $this->images[] = [
                    'id' => $media->id,
                    'file' => $media,
                    'clientOriginalName' => $media->name,
                    'filename' => $media->name,
                    'temporaryUrl' => $media->getFullUrl(),
                    'caption' => $media->getCustomProperty('caption')
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.component.editor.photo');
    }

    public function updatedUploads()
    {
        $this->validate();

        foreach ($this->uploads as $v) {
            $this->images[] = [
                'file' => $v,
                'clientOriginalName' => $v->getClientOriginalName(),
                'filename' => $v->getFilename(),
                'temporaryUrl' => $v->temporaryUrl(),
                'caption' => null
            ];
        }
    }

    public function removeImage($index)
    {
        array_splice($this->images, $index, 1);
    }

    public function save()
    {
        if ($this->block->id) {

            // Edit 流程
            // 圖檔有新有舊
            // ．舊的不理（要改 caption)
            // ．新的加入
            // ．被移掉的刪除

            $ids = [];

            foreach ($this->images as $image) {

                if (!isset($image['id'])) {

                    $media = $this->addMedia($image);

                    $ids[] = $media->id;
                } else {
                    $media = Media::find($image['id']);

                    $media->setCustomProperty('caption', $image['caption']);
                    $media->save();
//
                    $ids[] = $image['id'];
                }

            }

            $this->block->media()->whereNotIn('id', $ids)->delete();

            $this->emit('PHOTO_BLOCK_UPDATED', $this->block->id);


        } else {
            // Create 流程
            // 圖檔會全都是新上傳
            $this->block->type = 'photo';
            $this->block->enabled = true;
            $this->block->save();

            foreach ($this->images as $image) {

                $this->addMedia($image);
            }

            $this->emit('PHOTO_BLOCK_CREATED', $this->block->id);
        }
    }

    public function resetImage()
    {
        $this->reset('image');
        $this->iteration++;
    }

    /**
     * @param $image
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function addMedia($image)
    {
        $path = $image['file']->store('images');
        $m = getimagesize(storage_path('app/' . $path));

        return $this->block->addMediaFromDisk($path)
            ->withCustomProperties([
                'width' => $m[0],
                'height' => $m[1],
                'caption' => $image['caption']
            ])
            ->toMediaCollection();
    }
}
