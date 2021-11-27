<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class WebUrl extends Component
{
    public $website_url;
    public $changed = false;
    public Model $item;

    protected $messages = [
        'website_url.url' => '必須為網址',
    ];
    protected $rules = [
        'website_url' => 'nullable|url'
    ];

    public function mount(Model $item)
    {
        $this->item = $item;
        $this->website_url = $item->website_url;
    }

    public function render()
    {
        return view('livewire.component.editor.web-url');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->item->website_url == $this->website_url) {
            $this->changed = false;
        } else {
            $this->changed = true;
        }
    }

    public function save()
    {
        $this->item->website_url = $this->website_url;
        $this->item->save();

        $this->changed = false;
    }
}
