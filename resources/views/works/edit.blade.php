<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('WORK') }}
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
                    <li><a href="{{ route('works.index') }}" class="font-bold">WORK</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li>編輯 WORK</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- CONTENT --}}
                <livewire:work.group :group-id="$groupId" :language-id="$languageId" upload-label="更換圖檔" />
                {{-- /CONTENT--}}
            </div>
        </div>
    </div>

    @push('headScripts')
        <style>
            .trix-button--icon-quote,
            .trix-button--icon-attach,
            .trix-button--icon-increase-nesting-level,
            .trix-button--icon-decrease-nesting-level,
            .trix-button--icon-code {
                display: none;
            }
            .trix-button-group--file-tools {
                border: none !important;
            }
            .trix-editor h1, #blocks h1 {
                font-size: 32px;
                font-weight: bolder;
            }
            .trix-editor ul, .trix-editor ol, #blocks ul, #blocks ol {
                padding-left: 30px;
            }
            .trix-editor ul li, #blocks ul li {
                list-style: disc;
            }
            .trix-editor ol li, #blocks ul li {
                list-style: decimal;
            }
            .trix-editor a, #blocks a {
                text-decoration: underline;
                color: #2563eb;
            }
            ul li {
                list-style-type:  none !important;
            }
        </style>
    @endpush
</x-app-layout>
