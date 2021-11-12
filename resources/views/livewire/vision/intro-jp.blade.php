<div>

    @if($finish)
        <div>
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6" id="review">

                <div class="text-xl text-center">修改完成</div>

                <hr>

                <div>
                    {!! $setting->value !!}
                </div>

            </div>
            <div class="px-4 pt-3 pb-5 bg-gray-50 text-right sm:px-6">
                <a
                    href="{{ route('vision.index') }}"
                    class="inline-flex justify-center py-2 px-4 text-sm font-medium text-gray-700 hover:text-gray-500"
                >
                    回上頁
                </a>
            </div>
        </div>

    @else

        <div>
            <div class="p-6">
                <div x-data="{ trix: @entangle('setting.value').defer }">
                    <input id="content" name="content" type="hidden"/>
                    <div wire:ignore>
                        <trix-editor class="trix-editor" wire:model.debounce.999999ms="setting.value">
                        </trix-editor>
                    </div>
                </div>
                <div class="mt-4">* 字數上限300字</div>
            </div>


            <div class="w-full p-4 bg-gray-100">
                @if(!$processing)
                    <button type="button"
                            class="mx-auto flex space-x-1.5 items-center justify-center py-2 px-4 border border-gray-800 shadow-sm sm:text-sm font-medium rounded-md text-white bg-gray-800 focus:outline-none"
                            wire:click="save"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <div>儲存內容區塊</div>
                    </button>
                @else
                    <button type="button"
                            class="mx-auto flex space-x-1.5 items-center justify-center py-2 px-4 border border-gray-300 shadow-sm sm:text-sm font-medium rounded-md text-white bg-gray-300 focus:outline-none"
                            disabled
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <div>儲存內容區塊</div>
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>

