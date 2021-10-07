<?php

namespace App\Http\Livewire\Member;

use App\Models\Member;
use App\Models\Specialty;
use App\Models\Team;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Member $member;
    public $image;
    public $iteration = 0; // for file input cleaning file name
    public $max;
    public $sort;
    public bool $finish = false;
    public $uploadLabel = '上傳圖檔';

    public $teams;
    public $specialties;

    protected $validationAttributes = [
        'member.name' => '名稱',
    ];

    protected $messages = [
        'image.required' => '請上傳圖檔',
        'image.image' => '圖檔必須為 jpg,gif,png 格式',
        'image.max' => '圖檔不可超過 1MB',
    ];

    protected function rules()
    {
        $rules = [
            'member.name' => 'required|string',
            'member.title' => 'required|string',
            'member.team_id' => 'required|integer',
            'member.specialty_id' => 'required|integer',
            'sort' => 'integer',
            'member.enabled' => 'boolean'
        ];

        if (!$this->member->hasMedia()) $rules['image'] = 'required|image|max:1024';

        return $rules;
    }

    public function mount(Member $member)
    {
        $this->member = $member;

        if($this->member->sort) {
            $this->max = Member::max('sort');
            $this->sort = $this->member->sort;
        } else {
            $this->max = Member::max('sort') + 1;
            $this->sort = $this->max;
        }

        if ($this->member->enabled == null) $this->member->enabled = false;

        $this->teams = Team::all();

        if (!$this->member->team_id) $this->member->team_id = $this->teams[0]->id;

        $this->specialties = Specialty::all();

        if (!$this->member->specialty_id) $this->member->specialty_id = $this->specialties[0]->id;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetImage()
    {
        $this->reset('image');
        $this->iteration++;
    }

    public function save()
    {
        $this->validate();

        // 重新排序

        if ($this->member->sort) {

            if ($this->member->sort < $this->sort) {
                Member::where('sort', '<=', $this->sort)->where('sort', '>', $this->member->sort)->decrement('sort');
            } elseif ($this->member->sort > $this->sort) {
                Member::where('sort', '>=', $this->sort)->where('sort', '<', $this->member->sort)->increment('sort');
            }

        } else {
            Member::where('sort', '>=', $this->sort)->increment('sort');
        }

        $this->member->sort = $this->sort;
        $this->member->save();

        // 有上傳/更新圖檔
        if ($this->image) {
            $path = $this->image->store('images');

            $image = getimagesize(storage_path('app/' . $path));
            $width = $image[0];
            $height = $image[1];

            // 刪掉原本的圖檔
            $this->member->clearMediaCollection();

            $this->member->addMediaFromDisk($path)
                ->withCustomProperties(['width' => $width, 'height' => $height])
                ->toMediaCollection();
        }

        $this->finish = true;
    }

    public function render()
    {
        return view('livewire.member.edit');
    }
}
