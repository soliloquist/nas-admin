<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('UPDATE') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:update.group />
    </div>



    @push('headScripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
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
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/maxeckel/alpine-editor@0.3.1/dist/alpine-editor.min.js"></script>
    @endpush
</x-app-layout>

