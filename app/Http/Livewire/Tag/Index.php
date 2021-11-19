<?php

namespace App\Http\Livewire\Tag;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $modal = false;
    public $selected = [];

    protected $listeners = ['confirm' => 'delete', 'cancel' => 'hideModal'];

    /**
     * 修改排序
     * @param $id
     * @param $value
     */
    public function onChangeSort($id, $value)
    {
        $item = Tag::find($id);

        if ($item->sort < $value) {
            Tag::where('sort', '<=', $value)->where('sort', '>', $item->sort)->decrement('sort');
        } elseif ($item->sort > $value) {
            Tag::where('sort', '>=', $value)->where('sort', '<', $item->sort)->increment('sort');
        }

        $item->sort = $value;
        $item->save();

    }

    public function onClickDelete($id)
    {
        $this->selected[] = $id;
        $this->modal = true;
    }

    public function delete()
    {
        Tag::whereIn('id', $this->selected)->delete();

        $this->hideModal();
    }

    public function hideModal()
    {
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.tag.index', [
            'tags' => Tag::orderBy('sort')->paginate(20)
        ]);
    }
}
