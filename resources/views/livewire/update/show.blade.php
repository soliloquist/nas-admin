<div>

    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <livewire:component.editor.image :item="$update" />

        <div class="border-t border-gray-200 py-4">
            <label class="block text-sm font-medium text-gray-700">
                名稱
            </label>
            <div class="mt-1">
                <livewire:component.editor.title :item="$update" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                啟用
            </label>
            <div class="mt-1 flex">
                <livewire:component.editor.enabled :item="$update" />
            </div>
        </div>
    </div>

    <hr>
    <div id="blocks" class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div>內文區塊</div>

        <div>
            <livewire:component.editor.block :item="$update" />
        </div>
    </div>
</div>
