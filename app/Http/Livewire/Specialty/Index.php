<?php

namespace App\Http\Livewire\Specialty;

use App\Models\Specialty;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $modal = false;
    public $selected = [];

    protected $rules = [
        'specialties.*.sort' => 'required|int'
    ];

    protected $listeners = ['confirm' => 'delete', 'cancel' => 'hideModal'];

    public function onClickDelete($id)
    {
        $this->selected[] = $id;
        $this->modal = true;
    }

    /**
     * 修改排序
     * @param $id
     * @param $value
     */
    public function onChangeSort($id, $value)
    {
        $item = Specialty::find($id);

        if ($item->sort < $value) {
            Specialty::where('sort', '<=', $value)->where('sort', '>', $item->sort)->decrement('sort');
        } elseif ($item->sort > $value) {
            Specialty::where('sort', '>=', $value)->where('sort', '<', $item->sort)->increment('sort');
        }

        $item->sort = $value;
        $item->save();

    }

    public function delete()
    {
        Specialty::whereIn('id', $this->selected)->delete();

        $this->hideModal();
    }

    public function hideModal()
    {
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.specialty.index', [
            'specialties' => Specialty::orderBy('sort')->paginate(20)
        ]);
    }
}
