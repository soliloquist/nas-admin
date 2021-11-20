<div>
    <label class="block text-sm font-medium text-gray-700">
        {{ $label }} （如不上傳此項，會自動使用基本圖檔做為縮圖）
    </label>
    <div class="mt-1 text-sm font-medium text-gray-500">* 建議尺寸 600 x 600 px。如不符合，上傳後會自動裁切</div>
    <div class="mt-1 flex rounded-md shadow-sm">
        <input
            wire:model="thumbnail"
            type="file"
            id="thumbnail-{{ $iteration }}"
            class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300"
        >
    </div>
    @if ($image && !$errors->has('thumbnail'))
        <div class="mt-4">
            <div>Preview:</div>
            <div class="mt-2 flex items-center">
                <div class="w-2/3">
                    <div class="w-96 h-96 bg-contain bg-no-repeat" style="background-image: url({{ $image->temporaryUrl() }})"> </div>
                </div>
                <div class="w-1/3">
                    <button type="button" class="bg-red-600 text-white py-2 px-4 mx-auto flex" wire:click="resetThumbnail">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        RESET
                    </button>
                </div>
            </div>
        </div>
    @endif
    @error('thumbnail') <span class="text-red-600">{{ $message }}</span> @enderror
</div>
