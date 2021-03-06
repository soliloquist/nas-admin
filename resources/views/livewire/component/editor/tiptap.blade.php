<div>
    <!-- The editor -->
    <div>
        <h2>Editor</h2>
        <x-tiptap wire:model="content" />
    </div>

    <div class="w-full p-4 bg-gray-100">
        @error('content')
        <div class="text-red-600 text-center">{{ $message }}</div> @enderror
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
