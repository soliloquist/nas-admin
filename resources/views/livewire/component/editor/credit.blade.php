<div>
    <div>
        @foreach($credits as $credit)
            <div class="flex">
                <div class="mr-3 space-y-2">
                    @if(!$loop->first)
                        <div class="px-1 mt-3">
                            <div class="cursor-pointer bg-gray-200 p-1 rounded-full"
                                 wire:click="changeTeamSort({{$loop->index}}, {{$loop->index-1}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 15l7-7 7 7"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                    @if(!$loop->last)
                        <div class="px-1 mt-3">
                            <div class="cursor-pointer bg-gray-200 p-1 rounded-full"
                                 wire:click="changeTeamSort({{$loop->index}}, {{$loop->index+1}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="pb-8 flex-1">
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
                                <div>刪除 Team 及 Team Member</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-2">

                        <div class="w-1/6 pt-3">Team Member</div>

                        <div>
                            @foreach($credit['people'] as $p)
                                <div class="mt-1 flex shadow-sm items-center">
                                    <div class="w-auto">
                                        <input
                                            wire:model="credits.{{ $loop->parent->index }}.people.{{ $loop->index }}"
                                            type="text"
                                            class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full sm:text-sm border-gray-300"
                                            placeholder="">
                                    </div>
                                    <div class="flex w-24">
                                        @if(!$loop->first)
                                            <div class="px-1">
                                                <div class="cursor-pointer bg-gray-200 p-1 rounded-full"
                                                     wire:click="changeMemberSort({{$loop->parent->index}}, {{$loop->index}}, {{$loop->index -1}})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M5 15l7-7 7 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                        @if(!$loop->last)
                                            <div class="px-1">
                                                <div class="cursor-pointer bg-gray-200 p-1 rounded-full"
                                                     wire:click="changeMemberSort({{$loop->parent->index}}, {{$loop->index}}, {{$loop->index +1}})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M19 9l-7 7-7-7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="cursor-pointer flex space-x-1.5"
                                             wire:click="onClickRemoveMember({{$loop->parent->index}}, {{$loop->index }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div>刪除 Member</div>
                                        </div>
                                    </div>

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
                                    新增 Member
                                </button>
                            </div>
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
                <div wire:click="onClickAddCredit">新增 Team</div>
            </button>
        </div>
    </div>
    <div class="mt-6">
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
