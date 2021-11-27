<div>
    <div>
        <div class="text-xl">
            縮圖預覽
        </div>
        @if($item->getFirstMedia('thumbnail') && !$image)
            <div>
                <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="">
            </div>
        @else
            <div class="text-md mt-2 text-gray-300">未上傳縮圖</div>
        @endif

        <div class="mt-4">
            <x-forms.image-upload :label="$this->uploadLabelName" :image="$image" :iteration="$iteration" class="w-96 h-96"/>
        </div>


        <div class="mt-4">
            @if ($changed)
                <button
                    type="button"
                    wire:loading.attr="disabled"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    wire:click="save()"
                >
                    <svg
                        wire:loading
                        wire:target="save"
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    未儲存
                </button>
            @else
                <button
                    type="button"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-300 cursor-default"
                    disabled
                    wire:click="save()"
                >
                    Done
                </button>
            @endif
        </div>
    </div>
</div>
