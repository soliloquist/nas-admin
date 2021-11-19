<?php

namespace App\Http\Livewire\Client;

use App\Models\Client;
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
        $item = Client::find($id);

        if ($item->sort < $value) {
            Client::where('sort', '<=', $value)->where('sort', '>', $item->sort)->decrement('sort');
        } elseif ($item->sort > $value) {
            Client::where('sort', '>=', $value)->where('sort', '<', $item->sort)->increment('sort');
        }

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
        $items = Client::whereIn('id', $this->selected)->get();

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
        return view('livewire.client.index', [
            'clients' => Client::when($this->filter, function($query) {
                $query->where('name', 'like', '%'.$this->filter.'%');
            })->orderBy($this->orderBy, $this->ordering)->paginate(20)
        ]);
    }
}
