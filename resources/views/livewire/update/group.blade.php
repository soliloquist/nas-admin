<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="flex items-center">
            <label class="block text-sm font-medium text-gray-700">
                排序
            </label>
            <div class="ml-4">
                <input
                    wire:model="sort"
                    type="number"
                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-24 rounded-none sm:text-sm border-gray-300"
                    min="1"
                    max="{{$max}}"
                    placeholder=""
                >
            </div>
            @error('sort') <div class="text-red-600 ml-2">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="bg-gray-200 border-t border-gray-300">

        <ul class="flex">
            @foreach($languages as $lang)
                <li class="py-3 px-6 border-r border-gray-300
                    @if($tab == $lang->id)
                    bg-white
                    @else
                    bg-gray-100
                    cursor-pointer
                    @endif"
                    wire:click="switchTab({{$lang->id}})">{{ $lang->label }}</li>
            @endforeach
        </ul>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        @foreach($languages as $lang)
            <div
                class="@if( $tab != $lang->id) hidden @endif"
            >
                <livewire:update.edit :group-id="$groupId" :language-id="$lang->id" :save-button-text="'儲存'.$lang->label.'版'" key="{{ $lang->code.'-'.now() }}" :sort="$sort"/>
            </div>
        @endforeach
    </div>
</div>
