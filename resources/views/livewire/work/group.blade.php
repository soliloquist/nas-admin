<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="px-4 pt-5 pb-2 bg-white">
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
    <div class="px-4 pb-5 pt-2 bg-white">
        <div class="flex">
            <label class="block text-sm font-medium text-gray-700 pt-3">
                網址
            </label>

            <div class="ml-4">
                <div class="mt-1 flex shadow-sm items-center bg-gray-200 border border-gray-300">
                    <div class="px-2 text-gray-500">
                        https://www.nextanimationstudio.com/work/
                    </div>
                    <input
                        wire:model="slug"
                        type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full sm:text-sm border-0"
                        placeholder="">
                </div>
                <div class="mt-2">
                    <ul class="text-gray-700 text-sm list-disc pl-6">
                        <li>只可使用文字及-或_符號，不可有空格。</li>
                        <li>不同文章網址不可重覆；但同一文章之不同語言版本，可使用相同網址</li>
                        <li>如使用非英文網址，在轉貼時（如轉貼到Facebook），可能會被轉譯為編碼型式，但連結仍有效。</li>
                    </ul>
                </div>
                @error('slug')
                <div class="text-red-600 mt-2">{{ $message }}</div> @enderror
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
                <livewire:work.edit :group-id="$groupId" :language-id="$lang->id" :save-button-text="'儲存'.$lang->label.'版'" key="{{ $lang->code.'-'.now() }}" :sort="$sort" :slug="$slug"/>
            </div>
        @endforeach
    </div>
</div>
