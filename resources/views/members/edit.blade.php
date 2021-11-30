<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('MEMBER') }}
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-md">
            <nav
                class="block text-sm text-left text-gray-600 bg-gray-500 bg-opacity-10 h-12flex items-center p-4 rounded-md"
            >
                <ol class="list-reset flex text-grey-dark">
                    <li><a href="/" class="font-bold">HOME</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('members.index') }}" class="font-bold">MEMBER</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li>編輯 {{ $member->name }} </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- CONTENT --}}
                <livewire:member.edit :member="$member" upload-label="更換圖檔" />
                {{-- /CONTENT--}}
            </div>
        </div>
    </div>
</x-app-layout>
