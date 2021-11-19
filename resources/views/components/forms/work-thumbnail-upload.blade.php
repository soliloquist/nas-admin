<div>
    <label class="block text-sm font-medium text-gray-700">
        * {{ $label }}
    </label>
    <div class="mt-1 flex rounded-md shadow-sm">
        <input
            wire:model="image"
            type="file"
            id="thumbnail-{{ $iteration }}"
            class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300"
        >
    </div>
    @if ($image && !$errors->has('image'))
        <div class="mt-4">
            <div>Preview:</div>
            <div class="mt-2 flex items-center">
                <div class="w-2/3">
                    <img class="w-auto" src="{{ $image->temporaryUrl() }}" alt="">
                </div>
                <div class="w-1/3">
                    <button type="button" class="bg-red-600 text-white py-2 px-4 mx-auto flex" wire:click="resetImage">
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
    @error('image') <span class="text-red-600">{{ $message }}</span> @enderror
</div>
