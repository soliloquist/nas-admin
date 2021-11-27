<div>
    @if($showBlockEditor)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!--
                  Background overlay, show/hide based on modal state.

                  Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                  Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full lg:max-w-4xl">
                    <div class="max-w-6xl">
                        <div class="flex items-center px-6 py-4 bg-gray-100 w-full">

                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="sm:text-sm">
                                    @if($blockEditorSort)
                                        編輯
                                    @else
                                        新增
                                    @endif

                                    @switch($blockEditorType)
                                        @case('text')
                                        文字內容
                                        @break
                                        @case('photo')
                                        圖配文區塊（可複選）
                                        @break
                                        @case('album')
                                        純圖片區塊（可複選）
                                        @break
                                    @endswitch
                                </div>
                            </div>

                            <div class="ml-auto">
                                <button type="button" class="bg-gray-800 text-white p-2 rounded-full"
                                        wire:click="onCloseEditBlock">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        {{-- Content--}}
                        <div class="px-6 py-8">
                            @switch($blockEditorType)
                                @case('text')
                                <livewire:trix :block="$blockEditorModel"/>
                                @break
                                @case('photo')
                                <livewire:component.editor.photo :block="$blockEditorModel"/>
                                @break
                                @case('album')
                                <livewire:component.editor.album :block="$blockEditorModel"/>
                                @break
                            @endswitch
                        </div>
                        {{-- END Content--}}
                    </div>

                </div>
            </div>
        </div>

    @endif
    <div class="border-t border-gray-400 py-6">

        @if($blocks)

            @foreach($blocks as $block)
                <div class="border border-gray-200 mb-2" wire:key="block-{{$block['sort']}}">

                    <div class="bg-gray-100 flex justify-end space-x-1.5 p-2">
                        @if(!$loop->first)
                            <button type="button" class="bg-gray-800 text-white p-2 rounded-md"
                                    wire:click="sortDecrease({{ $block['sort'] }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 15l7-7 7 7"/>
                                </svg>
                            </button>
                        @endif
                        @if(!$loop->last)
                            <button type="button" class="bg-gray-800 text-white p-2 rounded-md"
                                    wire:click="sortIncrease({{ $block['sort'] }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        @endif
                        <button type="button" class="bg-gray-800 text-white p-2 rounded-md"
                                wire:click="onClickEditBlock({{$block['sort']}})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>

                        <button type="button" class="bg-red-600 text-white p-2 rounded-md"
                                wire:click="onClickRemoveBlock({{$block['sort']}})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        @switch($block['type'])
                            @case('text')

                            {!! $block['content'] !!}

                            @break

                            @case('photo')

                            <div class="flex">
                                @foreach($block['content'] as $img)
                                    <div class="w-1/4 px-2">
                                        <div>
                                            <img src="{{ $img['fullUrl'] }}" alt="">
                                        </div>
                                        <div class="text-sm mt-2">
                                            {{ $img['caption'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @break

                            @case('album')

                            <div class="flex">
                                @foreach($block['content'] as $img)
                                    <div class="w-1/4 px-2">
                                        <div>
                                            <img src="{{ $img['fullUrl'] }}" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @break
                        @endswitch
                    </div>
                </div>
            @endforeach

        @else
            <div class="ml-4 mt-4 text-gray-700 sm:text-sm text-center">尚無內容</div>
        @endif
    </div>

    <div class="flex space-x-1.5 justify-center">
        <button
            type="button"
            class="flex space-x-1.5 items-center justify-center py-2 px-4 border border-gray-800 shadow-sm sm:text-sm font-medium rounded-md  focus:outline-none"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            <div wire:click="onClickAddTextBlock">新增文字區塊</div>
        </button>

        <button
            type="button"
            class="flex space-x-1.5 items-center justify-center py-2 px-4 border border-gray-800 shadow-sm sm:text-sm font-medium rounded-md  focus:outline-none"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <div wire:click="onClickAddPhotoBlock">新增圖配文區塊</div>
        </button>

        <button
            type="button"
            class="flex space-x-1.5 items-center justify-center py-2 px-4 border border-gray-800 shadow-sm sm:text-sm font-medium rounded-md  focus:outline-none"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/>
            </svg>
            <div wire:click="onClickAddAlbumBlock">新增純圖片區塊</div>
        </button>
    </div>
</div>
