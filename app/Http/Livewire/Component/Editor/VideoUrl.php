<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class VideoUrl extends Component
{
    public $video_url;
    public $changed = false;
    public Model $item;

    protected $messages = [
        'video_url.url' => '必須為網址',
    ];

    protected $rules = [
        'video_url' => 'nullable|url'
    ];

    public function mount(Model $item)
    {
        $this->item = $item;
        $this->video_url = $item->video_url;
    }

    public function render()
    {
        return view('livewire.component.editor.video-url');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->item->video_url == $this->video_url) {
            $this->changed = false;
        } else {
            $this->changed = true;
        }
    }

    public function save()
    {
        $this->item->video_url = $this->video_url;
        $this->item->save();

        $this->changed = false;
    }
}
