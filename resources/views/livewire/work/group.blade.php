<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="px-4 pt-5 pb-2 bg-white">
        <div class="flex items-center">
            <label class="block text-sm font-medium text-gray-700">
                排序
            </label>
            <div class="ml-4 flex">
                <div>
                    <input
                        wire:model="sort"
                        type="number"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-24 rounded-none sm:text-sm border-gray-300"
                        min="1"
                        max="{{$max}}"
                        placeholder=""
                    >
                </div>

                <div class="pl-2">
                    @if ($sortChanged)
                        <button
                            type="button"
                            wire:loading.attr="disabled"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            wire:click="saveSort()"
                        >
                            <svg
                                wire:loading
                                wire:target="saveSort"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            儲存變更
                        </button>
                    @else
                        <button
                            type="button"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-300 cursor-default"
                            disabled
                            wire:click="saveSort()"
                        >
                            Done
                        </button>
                    @endif
                </div>
            </div>
            @error('sort')
            <div class="text-red-600 ml-2">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="px-4 pb-5 pt-2 bg-white">
        <div class="flex">
            <label class="block text-sm font-medium text-gray-700 pt-3">
                網址
            </label>

            <div class="ml-4">
                <div class="flex mt-1">
                    <div class="flex shadow-sm items-center bg-gray-200 border border-gray-300">
                        <div class="px-2 text-gray-500">
                            https://www.nextanimationstudio.com/work/
                        </div>
                        <input
                            wire:model="slug"
                            type="text"
                            class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full sm:text-sm border-0"
                            placeholder="">
                    </div>
                    <div class="pl-2">
                        @if ($slugChanged)
                            <button
                                type="button"
                                wire:loading.attr="disabled"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                wire:click="saveSlug()"
                            >
                                <svg
                                    wire:loading
                                    wire:target="saveSlug"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                儲存變更
                            </button>
                        @else
                            <button
                                type="button"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-300 cursor-default"
                                disabled
                                wire:click="saveSlug()"
                            >
                                Done
                            </button>
                        @endif
                    </div>
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
            @error('sort')
            <div class="text-red-600 ml-2">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="bg-gray-200 border-t border-gray-300">

        <ul class="flex">
            @foreach($languages as $lang)
                <li class="py-3 px-6 border-r border-gray-300
                    @if($lang->id == $languageId)
                    bg-white
                    @else
                    bg-gray-100
                    cursor-pointer
                    @endif"
                >
                    <a href="{{ route('works.edit', ['groupId' => $groupId, 'languageId' => $lang->id]) }}">
                        {{ $lang->label }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <livewire:work.show :group-id="$groupId" :language-id="$languageId" wire:key="'{{$groupId . '-'. $lang->id}}'"/>
    </div>
</div>
