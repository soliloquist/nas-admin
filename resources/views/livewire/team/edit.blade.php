@if($finish)
    <div>
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            @if(request()->routeIs('teams.create'))
                <div class="text-xl text-center">新增完成</div>
            @else
                <div class="text-xl text-center">修改完成</div>
            @endif
            <hr>

            <div class="flex">
                <div class="md:w-1/5 text-gray-700 font-medium">名稱</div>
                <div>{{ $team->title }}</div>
            </div>

            <div class="flex">
                <div class="md:w-1/5 text-gray-700 font-medium">排序</div>
                <div>{{ $team->sort }}</div>
            </div>

            <div class="flex">
                <div class="md:w-1/5 text-gray-700 font-medium">啟用</div>
                <div>{{ $team->enabled ? '是':'否' }}</div>
            </div>

        </div>
        <div class="px-4 pt-3 pb-5 bg-gray-50 text-right sm:px-6">
            <a
                href="{{ route('teams.index') }}"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                回列表頁
            </a>
            @if(request()->routeIs('teams.create'))
                <a
                    href="{{ route('teams.create') }}"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    繼續新增
                </a>
            @endif
        </div>
    </div>
@else
    <form wire:submit.prevent="save">

        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    * 名稱
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input
                        wire:model="team.title"
                        type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                        placeholder="">
                </div>
                @error('team.title') <span class="text-red-600">{{ $message }}</span> @enderror
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
                        wire:model="team.enabled"
                        type="checkbox"
                        class="focus:ring-indigo-500 focus:border-indigo-500 rounded sm:text-sm border-gray-300"
                        placeholder="https://www.test.com"
                    >
                </div>
            </div>
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
