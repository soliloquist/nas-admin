
<div
    x-data="{content: @entangle($attributes->wire('model')),...setupEditor()}"
    x-init="() => init($refs.editor)"
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model') }}>

    <template x-if="editor">
        <div class="mb-2 flex justify-between">
            <div class="flex gap-1">
                <button
                    class="flex items-center px-3 py-1 bg-gray-200 rounded-lg shadow-xs cursor-pointer hover:bg-gray-500 hover:text-gray-100"
                    :class="{ 'bg-gray-600': Alpine.raw(editor).isActive('bold') }"
                    @click="Alpine.raw(editor).chain().focus().toggleBold().run()"
                >
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M13.5,15.5H10V12.5H13.5A1.5,1.5 0 0,1 15,14A1.5,1.5 0 0,1 13.5,15.5M10,6.5H13A1.5,1.5 0 0,1 14.5,8A1.5,1.5 0 0,1 13,9.5H10M15.6,10.79C16.57,10.11 17.25,9 17.25,8C17.25,5.74 15.5,4 13.25,4H7V18H14.04C16.14,18 17.75,16.3 17.75,14.21C17.75,12.69 16.89,11.39 15.6,10.79Z" />
                    </svg>
                </button>
                <button
                    class="flex items-center px-3 py-1 bg-gray-200 rounded-lg shadow-xs cursor-pointer hover:bg-gray-500 hover:text-gray-100"
                    :class="{ 'bg-gray-600': Alpine.raw(editor).isActive('heading', { level: 1 }) }"
                    @click="Alpine.raw(editor).chain().focus().toggleHeading({ level: 1 }).run()"

                >
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M3,4H5V10H9V4H11V18H9V12H5V18H3V4M14,18V16H16V6.31L13.5,7.75V5.44L16,4H18V16H20V18H14Z" />
                    </svg>
                </button>

                <button
                    class="flex items-center px-3 py-1 bg-gray-200 rounded-lg shadow-xs cursor-pointer hover:bg-gray-500 hover:text-gray-100"
                    :class="{ 'bg-gray-600': Alpine.raw(editor).isActive('italic') }"
                    @click="Alpine.raw(editor).chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }"
                >
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M10,4V7H12.21L8.79,15H6V18H14V15H11.79L15.21,7H18V4H10Z" />
                    </svg>
                </button>

                <button
                    class="flex items-center px-3 py-1 bg-gray-200 rounded-lg shadow-xs cursor-pointer hover:bg-gray-500 hover:text-gray-100"
                    :class="{ 'bg-gray-600': Alpine.raw(editor).isActive('bulletList') }"
                    @click="Alpine.raw(editor).chain().focus().toggleBulletList().run()"
                >
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M7,5H21V7H7V5M7,13V11H21V13H7M4,4.5A1.5,1.5 0 0,1 5.5,6A1.5,1.5 0 0,1 4,7.5A1.5,1.5 0 0,1 2.5,6A1.5,1.5 0 0,1 4,4.5M4,10.5A1.5,1.5 0 0,1 5.5,12A1.5,1.5 0 0,1 4,13.5A1.5,1.5 0 0,1 2.5,12A1.5,1.5 0 0,1 4,10.5M7,19V17H21V19H7M4,16.5A1.5,1.5 0 0,1 5.5,18A1.5,1.5 0 0,1 4,19.5A1.5,1.5 0 0,1 2.5,18A1.5,1.5 0 0,1 4,16.5Z" />
                    </svg>
                </button>
                <button
                    class="flex items-center px-3 py-1 bg-gray-200 rounded-lg shadow-xs cursor-pointer hover:bg-gray-500 hover:text-gray-100"
                    :class="{ 'bg-gray-600': Alpine.raw(editor).isActive('orderedList') }"
                    @click="Alpine.raw(editor).chain().focus().toggleOrderedList().run()"
                >
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M7,13V11H21V13H7M7,19V17H21V19H7M7,7V5H21V7H7M3,8V5H2V4H4V8H3M2,17V16H5V20H2V19H4V18.5H3V17.5H4V17H2M4.25,10A0.75,0.75 0 0,1 5,10.75C5,10.95 4.92,11.14 4.79,11.27L3.12,13H5V14H2V13.08L4,11H2V10H4.25Z" />
                    </svg>
                </button>

                <button
                    class="flex items-center px-3 py-1 bg-gray-200 rounded-lg shadow-xs cursor-pointer hover:bg-gray-500 hover:text-gray-100"
                    @click="Alpine.raw(editor).chain().focus().clearNodes().unsetAllMarks().run()"
                >
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M6,5V5.18L8.82,8H11.22L10.5,9.68L12.6,11.78L14.21,8H20V5H6M3.27,5L2,6.27L8.97,13.24L6.5,19H9.5L11.07,15.34L16.73,21L18,19.73L3.55,5.27L3.27,5Z" />
                    </svg>
                </button>
            </div>

            <div class="flex gap-1">
                <button
                    class="flex items-center px-3 py-1 bg-gray-200 rounded-lg shadow-xs cursor-pointer hover:bg-gray-500 hover:text-gray-100"
                    @click="Alpine.raw(editor).chain().focus().undo().run()"
                >
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20 13.5C20 17.09 17.09 20 13.5 20H6V18H13.5C16 18 18 16 18 13.5S16 9 13.5 9H7.83L10.91 12.09L9.5 13.5L4 8L9.5 2.5L10.92 3.91L7.83 7H13.5C17.09 7 20 9.91 20 13.5Z" />
                    </svg>
                </button>
                <button
                    class="flex items-center px-3 py-1 bg-gray-200 rounded-lg shadow-xs cursor-pointer hover:bg-gray-500 hover:text-gray-100"
                    @click="Alpine.raw(editor).chain().focus().redo().run()"
                >
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M10.5 18H18V20H10.5C6.91 20 4 17.09 4 13.5S6.91 7 10.5 7H16.17L13.08 3.91L14.5 2.5L20 8L14.5 13.5L13.09 12.09L16.17 9H10.5C8 9 6 11 6 13.5S8 18 10.5 18Z" />
                    </svg>
                </button>
            </div>



        </div>
    </template>

    <div x-ref="editor"
         wire:click="onClick"
         class="tiptap-editor border border-gray-300 p-4"
    ></div>
</div>
