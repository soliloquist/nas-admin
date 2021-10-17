<?php

namespace App\Http\Livewire\Business;

use App\Models\Business;
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
        $items = Business::whereIn('id', $this->selected)->get();

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
        return view('livewire.business.index', [
            'businesses' => Business::when($this->filter, function($query) {
                $query->where('title', 'like', '%'.$this->filter.'%');
            })->orderBy($this->orderBy, $this->ordering)->paginate(20)
        ]);
    }
}
