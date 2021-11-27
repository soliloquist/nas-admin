<div>

    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <livewire:component.editor.image :item="$work" />

        <hr>

        {{-- 上傳縮圖 --}}
        <livewire:component.editor.thumbnail :item="$work" />


        <div class="border-t border-gray-200 py-4">
            <label class="block text-sm font-medium text-gray-700">
                名稱
            </label>
            <div class="mt-1">
                <livewire:component.editor.title :item="$work" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                影片連結（youtube影片網址）
            </label>
            <div class="mt-1">
                <livewire:component.editor.video-url :item="$work" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                網頁連結
            </label>
            <div class="mt-1">
                <livewire:component.editor.web-url :item="$work" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                啟用
            </label>
            <div class="mt-1 flex">
                <livewire:component.editor.enabled :item="$work" />
            </div>
        </div>
    </div>

    <hr>

    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="flex">Tags</div>
        <div class="border-t border-gray-400 py-6">
            <livewire:component.editor.tag :item="$work" />
        </div>
    </div>

    <hr>

    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div>專業類型</div>
        <div class="border-t border-gray-400 py-6">
            <livewire:component.editor.specialty :item="$work" />
        </div>
    </div>



    <hr>

    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div>Team Credit</div>
        <div class="border-t border-gray-400 py-6">
            <livewire:component.editor.credit :item="$work" />
        </div>
    </div>

    <hr>
    <div id="blocks" class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div>內文區塊</div>

        <div>
            <livewire:component.editor.block :item="$work" />
        </div>
    </div>
</div>
