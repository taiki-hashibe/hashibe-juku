<div class="relative" x-data="{ selectOpen: false }">
    <x-admin.form.input type="text" name="_post_tags" @focus="selectOpen=true" @click.outside="selectOpen = false"
        wire:model="filterFormValue" wire:keydown.debounce.100ms="filterFormOnChange()" />
    @error('tags')
        <div class="mt-2 text-sm text-rose-600">{{ $message }}</div>
    @enderror
    <ul x-show="selectOpen" x-cloak
        class="absolute left-0 top-full w-full max-h-52 overflow-y-auto bg-white border px-2 pt-2 pb-4 rounded-md">
        @foreach ($filteredTags as $tag)
            <li class="px-1">
                <button type="button" wire:click="tagSelect({{ $tag->id }})"
                    class="w-full px-2 py-1 mb-1 flex items-start rounded-md duration-100 hover:bg-slate-100">
                    {{ $tag->name }}
                </button>
            </li>
        @endforeach
    </ul>
    <ul x-cloak class="flex flex-wrap mt-4">
        @foreach ($selected as $t)
            <li class="me-2 mb-1" wire:key="{{ $t->id }}">
                <button type="button" wire:click="tagRemove({{ $t->id }})"
                    class="flex items-center px-1 py-px text-white font-bold bg-orange-500 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#ffffff" class="w-5 h-5 me-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ $t->name }}
                </button>
                <input type="hidden" name="tags[]" value="{{ $t->id }}">
            </li>
        @endforeach
    </ul>
</div>
