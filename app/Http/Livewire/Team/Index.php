<?php

namespace App\Http\Livewire\Team;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $modal = false;
    public $selected = [];

    protected $listeners = ['confirm' => 'delete', 'cancel' => 'hideModal'];

    public function mount()
    {

    }

    /**
     * 修改排序
     * @param $id
     * @param $value
     */
    public function onChangeSort($id, $value)
    {
        $item = Team::find($id);

        if ($item->sort < $value) {
            Team::where('sort', '<=', $value)->where('sort', '>', $item->sort)->decrement('sort');
        } elseif ($item->sort > $value) {
            Team::where('sort', '>=', $value)->where('sort', '<', $item->sort)->increment('sort');
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
        Team::whereIn('id', $this->selected)->delete();

        $this->hideModal();
    }

    public function hideModal()
    {
        $this->modal = false;
    }
    public function render()
    {
        return view('livewire.team.index', [
            'teams' => Team::orderBy('sort')->paginate(20)
        ]);
    }
}
