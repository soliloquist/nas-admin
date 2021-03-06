<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    @if($showAlert)
        <livewire:component.modal.created/>
    @endif

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
                                        ??????
                                    @else
                                        ??????
                                    @endif

                                    @switch($blockEditorType)
                                        @case('text')
                                        ????????????
                                        @break
                                        @case('photo')
                                        ??????????????????????????????
                                        @break
                                        @case('album')
                                        ??????????????????????????????
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
                                <livewire:component.editor.tiptap :block="$blockEditorModel"/>
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

    <form wire:submit.prevent="save">
        <div class="px-4 pt-5 pb-2 bg-white">
            <div class="flex items-start">
                <div class="block text-sm font-medium text-gray-700">
                    ????????????????????????
                </div>
                <div class="ml-4">
                    <div class="flex space-x-5">
                        @foreach($langs as $lang)

                            <label>
                                <span class="text-sm text-gray-700"> {{ $lang->label }} </span>
                                <input
                                    wire:model="languageSelected"
                                    type="radio"
                                    value="{{ $lang->id }}"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 rounded-full sm:text-sm border-gray-300"
                                />
                            </label>

                        @endforeach
                    </div>
                    <div class="mt-2">
                        <ul class="text-sm text-gray-500 list-disc">
                            <li>????????????????????????????????????????????????????????????????????????????????????</li>
                            <li>????????????????????????????????????????????????????????????</li>
                        </ul>
                    </div>

                    @error('languageSelected')
                    <div class="text-red-600 mt-2">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="px-4 pt-5 pb-2 bg-white">
            <div class="flex items-center">
                <label class="block text-sm font-medium text-gray-700">
                    ??????
                </label>
                <div class="ml-4">
                    <input
                        wire:model.lazy="sort"
                        type="number"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-24 rounded-none sm:text-sm border-gray-300"
                        min="1"
                        max="{{$max}}"
                        placeholder=""
                    >
                </div>
            </div>
        </div>
        <div class="px-4 pb-5 pt-2 bg-white">
            <div class="flex">
                <label class="block text-sm font-medium text-gray-700 pt-3">
                    ??????
                </label>

                <div class="ml-4">
                    <div class="mt-1 flex shadow-sm items-center bg-gray-200 border border-gray-300">
                        <div class="px-2 text-gray-500">
                            https://www.nextanimationstudio.com/work/
                        </div>
                        <input
                            wire:model="slug"
                            type="text"
                            class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full sm:text-sm border-0"
                            placeholder="">
                    </div>
                    <div class="mt-2">
                        <ul class="text-gray-700 text-sm list-disc pl-6">
                            <li>?????????????????????-???_???????????????????????????</li>
                            <li>?????????????????????????????????????????????????????????????????????????????????????????????</li>
                            <li>??????????????????????????????????????????????????????Facebook???????????????????????????????????????????????????????????????</li>
                        </ul>
                    </div>
                    @error('slug')
                    <div class="text-red-600 mt-2">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>


        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">


            <x-forms.image-upload :label="$this->uploadLabel" :required="true" :image="$image" :iteration="$iteration"/>

            <hr>

            {{-- ???????????? --}}

            <x-forms.work-thumbnail-upload :label="$this->thumbnailLabel" :image="$thumbnail"
                                           :iteration="$iteration"/>


            <div>
                <label class="block text-sm font-medium text-gray-700">
                    * ??????
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input
                        wire:model="title"
                        type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                        placeholder="">
                </div>
                @error('title')
                <div class="text-red-600 mt-2">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    ???????????????youtube???????????????
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input
                        wire:model="videoUrl"
                        type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                        placeholder="https://www.youtube.com/watch?v=I6PHgtdxFrY">
                </div>
                @error('work.video_url') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    ????????????
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input
                        wire:model="websiteUrl"
                        type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                        placeholder="https://www.sample.com">
                </div>
                @error('work.website_url') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <hr>

        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div>Tags</div>
            <div class="border-t border-gray-400 py-6 grid grid-cols-4 gap-4">
                @foreach($tagOptions as $item)
                    <label class="mr-4 my-4 text-sm">
                        <input wire:model="tags" type="checkbox" value="{{ $item->id }}">
                        {{ $item->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <hr>

        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div>????????????</div>
            <div class="border-t border-gray-400 py-6">
                @foreach($specialties as $item)
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6" style="background-color: {{$item['color']}}"></div>
                        <div class="w-64 ml-4">{{ $item['name'] }}</div>
                        <x-rating :rating="$item['rate']" :itemId="$item['id']"/>
                    </div>
                @endforeach
            </div>
        </div>

        <hr>
        <div id="blocks" class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div>????????????</div>

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
                    <div class="ml-4 mt-4 text-gray-700 sm:text-sm text-center">????????????</div>
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
                    <div wire:click="onClickAddTextBlock">??????????????????</div>
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
                    <div wire:click="onClickAddPhotoBlock">?????????????????????</div>
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
                    <div wire:click="onClickAddAlbumBlock">?????????????????????</div>
                </button>
            </div>
        </div>

        <hr>

        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div>Team Credit</div>
            <div class="border-t border-gray-400 py-6">
                @foreach($credits as $item)
                    <div class="pb-8">
                        <div class="flex">
                            <div class="w-1/6 pt-3">Team</div>
                            <div class="">
                                <div class="mt-1 flex">
                                    <input
                                        wire:model="credits.{{ $loop->index }}.title"
                                        type="text"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full sm:text-sm border-gray-300"
                                        placeholder="">
                                </div>
                                @error('credits.'.$loop->index.'.title')
                                <div class="text-red-600">{{ $message }}</div> @enderror
                            </div>
                            <div class="py-2 ml-4">
                                <div class="cursor-pointer flex space-x-1.5"
                                     wire:click="onClickRemoveCredit({{$loop->index}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>?????? Team ??? Team Member</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex mt-2">
                            <div class="w-1/6 pt-3">Team Member</div>

                            <div>
                                @foreach($item['people'] as $p)
                                    <div class="mt-1 flex shadow-sm">
                                        <input
                                            wire:model="credits.{{ $loop->parent->index }}.people.{{ $loop->index }}"
                                            type="text"
                                            class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full sm:text-sm border-gray-300"
                                            placeholder="">
                                    </div>
                                @endforeach

                                <div class="mt-4">
                                    <button
                                        type="button"
                                        wire:click="onClickAddCreditPeople({{$loop->index}})"
                                        class="flex space-x-1.5 items-center justify-center py-2 px-4 bg-gray-300 shadow-sm sm:text-sm font-medium rounded-md focus:outline-none"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        ?????? Member
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div>
                    <button
                        type="button"
                        class="flex space-x-1.5 items-center justify-center py-2 px-4 bg-gray-300 shadow-sm sm:text-sm font-medium rounded-md focus:outline-none"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <div wire:click="onClickAddCredit">?????? Team</div>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-4 px-4 pt-3 pb-5 bg-gray-50 text-right sm:px-6 flex justify-end items-center">
            @if ($errors->any())
                <div class="text-red-600 sm:text-sm mr-3"> ?????????????????????????????????</div>
            @endif
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
                {{ $saveButtonText }}
            </button>
        </div>

        <!-- /resources/views/post/create.blade.php -->
        <div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </form>

</div>
