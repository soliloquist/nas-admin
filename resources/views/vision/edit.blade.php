<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            OUR VISION 頁面內容設定
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('vision.index') }}" class="text-indigo-600 hover:text-indigo-900 font-bold"> &lt; VISION</a>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- CONTENT --}}

                @livewire($path)
                {{-- /CONTENT--}}
            </div>
        </div>
    </div>

    @push('headScripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"/>
        <style>
            .trix-button--icon-quote,
            .trix-button--icon-attach,
            .trix-button--icon-increase-nesting-level,
            .trix-button--icon-decrease-nesting-level,
            .trix-button--icon-strike,
            .trix-button--icon-link,
            .trix-button--icon-heading-1,
            .trix-button--icon-bullet-list,
            .trix-button--icon-number-list,
            .trix-button--icon-code {
                display: none;
            }

            .trix-button-group--file-tools, .trix-button-group--block-tools {
                border: none !important;
            }

            .trix-editor h1, #review h1 {
                font-size: 32px;
                font-weight: bolder;
            }

            .trix-editor ul, .trix-editor ol, #review ul, #review ol {
                padding-left: 30px;
            }

            .trix-editor ul li, #review ul li {
                list-style: disc;
            }

            .trix-editor ol li, #review ul li {
                list-style: decimal;
            }

            .trix-editor a, #review a {
                text-decoration: underline;
                color: #2563eb;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/maxeckel/alpine-editor@0.3.1/dist/alpine-editor.min.js"></script>
    @endpush
</x-app-layout>
