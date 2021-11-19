<div>

    @if($modal)
        @livewire('component.modal.confirm', ['confirmBtnText' => '確認刪除'])
    @endif
    <div class="flex justify-between px-6 py-4 border-b">
        <div>
            <input wire:model.debounce.500ms="filter" class="py-2 px-4 border border-gray-300" name="filter" placeholder="輸入關鍵字查詢"/>
        </div>
        <div>
            <select class="border-gray-300" wire:change="onChangeSorting($event.target.value)">
                <option selected>顯示順序</option>
                <option value="1">排序從前到後</option>
                <option value="2">排序從後到前</option>
                <option value="3">新到舊</option>
                <option value="4">舊到新</option>
            </select>
        </div>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>

            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                名稱
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                TEAM
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                專業類型
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                排序
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                啟用
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                加入時間
            </th>
            <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($members as $item)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    @if($item->getFirstMedia())
                        <img src="{{ $item->getFirstMedia()->getUrl() }}" alt="" class="w-20">
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $item->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    @if($item->team)
                    {{ $item->team->title }}
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $item->specialty->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <div class="flex items-center">
                        <div>
                            <input
                                type="number"
                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-20 sm:text-sm border-gray-300"
                                value="{{$item->sort}}"
                                min="1"
                                max="{{$members->count()}}"
                                wire:change="onChangeSort({{$item->id}}, $event.target.value)"
                            >
                        </div>
                        @if($item->sort > 1)
                            <div class="px-1">
                                <div class="cursor-pointer bg-gray-200 p-1 rounded-full"
                                     wire:click="onChangeSort({{ $item->id }}, {{ $item->sort - 1 }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 15l7-7 7 7"/>
                                    </svg>
                                </div>
                            </div>
                        @endif
                        @if($item->sort < $members->count())
                            <div class="px-1">
                                <div class="cursor-pointer bg-gray-200 p-1 rounded-full"
                                     wire:click="onChangeSort({{ $item->id }}, {{ $item->sort + 1 }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $item->enabled ? '是':'否' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $item->created_at->format('Y-m-d H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end">
                        <div>
                            <a href="{{ route('members.edit', $item->id) }}"
                               class="text-indigo-600 hover:text-indigo-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="ml-2">
                            <button
                                wire:click="onClickDelete({{$item->id}})"
                                type="button"
                                class="text-red-600 hover:text-indigo-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">
        {{ $members->links() }}
    </div>
</div>

