<form wire:submit.prevent="save">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        @if($business->getFirstMedia() && !$image)
            <div>
                <img src="{{ $business->getFirstMediaUrl() }}" alt="" class="w-auto">
            </div>
        @endif

        <x-forms.image-upload :label="$uploadLabel" :image="$image" :iteration="$iteration"/>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                * 網址
            </label>
            <div class="mt-1 flex shadow-sm items-center bg-gray-200 border border-gray-300">
                <div class="px-2 text-gray-500">
                    https://www.nextanimationstudio.com/business/
                </div>
                <input
                    wire:model="business.slug"
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
            @error('business.slug') <div class="text-red-600 mt-2">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                * 名稱
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input
                    wire:model="business.title"
                    type="text"
                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                    placeholder="">
            </div>
            @error('business.title') <div class="text-red-600 mt-2">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                影片連結（youtube影片網址）
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input
                    wire:model="business.video_url"
                    type="text"
                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                    placeholder="https://www.youtube.com/watch?v=I6PHgtdxFrY">
            </div>
            @error('business.video_url') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                網頁連結
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input
                    wire:model="business.website_url"
                    type="text"
                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                    placeholder="https://www.sample.com">
            </div>
            @error('business.website_url') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                排序
            </label>
            <div class="mt-1">
                <input
                    wire:model="sort"
                    type="number"
                    min="1"
                    max="{{$max}}"
                    class="focus:ring-indigo-500 focus:border-indigo-500 rounded sm:text-sm border-gray-300"
                >
            </div>
            @error('sort') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                啟用
            </label>
            <div class="mt-1 flex">
                <input
                    wire:model="member.enabled"
                    type="checkbox"
                    class="focus:ring-indigo-500 focus:border-indigo-500 rounded sm:text-sm border-gray-300"
                    placeholder="https://www.test.com"
                >
            </div>
        </div>

        <input type="hidden" wire:model="business.language_id"/>
        <input type="hidden" wire:model="business.group_id"/>
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
