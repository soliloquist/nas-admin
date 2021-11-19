<?php

namespace App\Http\Livewire\Update;

use App\Models\Update;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $modal = false;
    public $selected = [];
    public $orderBy = 'sort';
    public $ordering = 'asc'; // asc | desc
    public $filter;

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
        $item = Update::find($id);

        if ($item->sort < $value) {
            Update::where('group_id', '!=', $item->group_id)->where('sort', '<=', $value)->where('sort', '>', $item->sort)->decrement('sort');
        } elseif ($item->sort > $value) {
            Update::where('group_id', '!=', $item->group_id)->where('sort', '>=', $value)->where('sort', '<', $item->sort)->increment('sort');
        }

        // 不同語系的同步更新
        Update::where('group_id', $item->group_id)->update(['sort' => $value]);

        $item->sort = $value;
        $item->save();

    }

    /**
     * 變更列表排序方式
     * @param $value
     */
    public function onChangeSorting($value)
    {
        switch ($value) {
            case 1:
                $this->orderBy = 'sort';
                $this->ordering = 'asc';
                break;
            case 2:
                $this->orderBy = 'sort';
                $this->ordering = 'desc';
                break;
            case 3:
                $this->orderBy = 'created_at';
                $this->ordering = 'desc';
                break;
            case 4:
                $this->orderBy = 'created_at';
                $this->ordering = 'asc';
                break;
        }
    }

    public function delete()
    {
        $items = Update::whereIn('id', $this->selected)->get();

        foreach ($items as $item) {
            $item->delete();
        }

        $this->hideModal();
    }

    public function hideModal()
    {
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.update.index', [
            'updates' => Update::when($this->filter, function($query) {
                $query->where('title', 'like', '%'.$this->filter.'%');
            })->groupBy('group_id')->orderBy($this->orderBy, $this->ordering)->paginate(20)
        ]);
    }
}
