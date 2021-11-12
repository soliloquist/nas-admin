@if($finish)
    <div>
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                <div class="text-xl text-center">修改完成</div>

            <hr>

            <div>
                <img class="w-auto" src="{{ $setting->getFirstMediaUrl() }}" alt="">
            </div>

        </div>
        <div class="px-4 pt-3 pb-5 bg-gray-50 text-right sm:px-6">
            <a
                href="{{ route('home') }}"
                class="inline-flex justify-center py-2 px-4 text-sm font-medium text-gray-700 hover:text-gray-500"
            >
                回上頁
            </a>
        </div>
    </div>
@else

    <form wire:submit.prevent="save">

        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            @if($setting->getFirstMedia() && !$image)
                <div>
                    <img src="{{ $setting->getFirstMediaUrl() }}" alt="" class="w-auto">
                </div>
            @endif

            <x-forms.image-upload :label="$uploadLabel" :image="$image" :iteration="$iteration"/>

            <div>建議尺寸： </div>

        </div>

        <div class="px-4 pt-3 pb-5 bg-gray-50 text-right sm:px-6">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                <svg
                    wire:loading
                    wire:target="save"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Save
            </button>
        </div>

    </form>
@endif
