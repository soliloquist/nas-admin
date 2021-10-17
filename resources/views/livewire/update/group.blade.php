<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-gray-200">

        <ul class="flex">
            @foreach($languages as $lang)
                <li class="py-3 px-6 border-r border-gray-300
                    @if($tab == $lang->id)
                    bg-white
                    @else
                    bg-gray-100
                    cursor-pointer
                    @endif"
                    wire:click="switchTab({{$lang->id}})">{{ $lang->label }}</li>
            @endforeach
        </ul>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        @foreach($languages as $lang)
            <div
                class="@if( $tab != $lang->id) hidden @endif"
            >
                <livewire:update.edit :group-id="$groupId" :language-id="$lang->id" :save-button-text="'儲存'.$lang->label.'版'" :key="$lang->id"/>
            </div>
        @endforeach
    </div>
</div>
