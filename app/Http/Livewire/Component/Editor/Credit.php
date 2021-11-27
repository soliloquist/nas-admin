<?php

namespace App\Http\Livewire\Component\Editor;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Credit extends Component
{
    public $changed = false;
    public Model $item;
    public $credits = [];
    public $old = [];

    protected $rules = [
        'credits.*.title' => 'required|string',
        'credits.*.people' => 'required|array'
    ];

    protected $validationAttributes = [
        'credits.*.title' => 'Team 名稱'
    ];

    public function mount(Model $item)
    {
        $this->item = $item;

        $this->credits = $this->item->credits->map(function ($item) {

            return [
                'id' => $item->id,
                'title' => $item->title,
                'people' => json_decode($item->people)
            ];

        })->toArray();

        $this->old = $this->item->credits->map(function ($item) {

            return [
                'id' => $item->id,
                'title' => $item->title,
                'people' => json_decode($item->people)
            ];

        })->toArray();

    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->old == $this->credits) {
            $this->changed = false;
        } else {
            $this->changed = true;
        }
    }

    public function onClickAddCredit()
    {
        $this->credits[] = [
            'id' => null,
            'title' => null,
            'people' => [null]
        ];
    }

    public function onClickRemoveCredit($index)
    {
        array_splice($this->credits, $index, 1);
    }

    public function onClickAddCreditPeople($index)
    {
        $this->credits[$index]['people'][] = null;
    }

    public function render()
    {
        return view('livewire.component.editor.credit');
    }

    public function save()
    {
        $creditsId = [];

        foreach ($this->credits as $key => $c) {

            $this->credits[$key]['people'] = array_filter($this->credits[$key]['people']);
            $p = json_encode($this->credits[$key]['people']);

            $credit = \App\Models\Credit::firstOrNew(['id' => $c['id']]);
            $credit->people = $p;
            $credit->title = $c['title'];
            $credit->work_id = $this->item->id;
            $credit->save();

            $creditsId[] = $credit->id;
        }

        \App\Models\Credit::where('work_id', $this->item->id)->whereNotIn('id', $creditsId)->delete();

        $this->changed = false;
    }

}
