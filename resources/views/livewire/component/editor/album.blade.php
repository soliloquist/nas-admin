<div>
    <div class="mt-1 flex rounded-md shadow-sm">
        <input
            wire:model="uploads"
            type="file"
            id="upload{{ $iteration }}"
            multiple
        >
    </div>
    <div class="mt-2">
        @error('uploads.*') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>
    <div class="mt-2 text-gray-600">* 2張圖片內，建議尺寸（寬）1074 x (高)792 px， 3張圖片以上，建議尺寸（寬）698 x (高)600px</div>
    <hr class="my-4">
    {{--  preview --}}
    <div>

        @foreach($images as $image)
            <div class="flex items-center border-gray-300 border-b py-2">
                <div class="w-3/12">
                    <img class="max-h-32" src="{{ $image['temporaryUrl'] }}">
                </div>
                <div class="ml-2 w-3/12 text-sm">
                    {{ $image['clientOriginalName'] }}
                </div>
                <div class="w-2/12 text-right">
                    <button type="button" class="bg-red-600 text-white p-2 rounded-md"
                            wire:click.prevent="removeImage({{ $loop->index }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-2">
        <button
            class="mx-auto flex space-x-1.5 items-center justify-center py-2 px-4 border shadow-sm sm:text-sm font-medium rounded-md text-white border-gray-800 bg-gray-800 focus:outline-none"
            wire:click.prevent="save"
            @if(count($images) == 0)
            disabled
            style="border-color:#ccc; background-color: #ccc"
            @endif
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <div>儲存圖片區塊</div>
        </button>
    </div>
</div>
