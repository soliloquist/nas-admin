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
        $max = Update::groupBy('group_id')->get()->count();

        if ($value > $max) {
            $value = $max;
        } elseif ($value < 1) {
            $value = 1;
        }

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

    public function onChangeEnabled($groupId, $langId)
    {
        $item = Update::where('group_id', $groupId)->where('language_id', $langId)->first();

        $item->enabled = !$item->enabled;
        $item->save();
    }

    public function delete()
    {
        $items = Update::whereIn('group_id', $this->selected)->get();

        foreach ($items as $item) {
            Update::where('group_id', '!=', $item->group_id)->where('sort', '>', $item->sort)->decrement('sort');
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
            'updates' => tap(Update::when($this->filter, function($query) {
                $query->where('title', 'like', '%'.$this->filter.'%');
            })->groupBy('group_id')->orderBy($this->orderBy, $this->ordering)->paginate(20))->map(function ($item) {
                $item->enEnabled = Update::where('language_id', 1)->where('group_id', $item->group_id)->value('enabled');
                $item->zhEnabled = Update::where('language_id', 2)->where('group_id', $item->group_id)->value('enabled');
                $item->jpEnabled = Update::where('language_id', 3)->where('group_id', $item->group_id)->value('enabled');
                return $item;
            })
        ]);
    }
}
