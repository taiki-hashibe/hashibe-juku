<x-backdrop x-show="{{ $key }}" :class="$backdropClass"></x-backdrop>
<div x-cloak x-show="{{ $key }}"
    class="{{ 'fixed top-[20%] left-0 w-screen flex justify-center px-3 sm:px-0 z-50 ' . $modalClass ?? '' }} }}"
    x-transition:enter="transition liner duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition liner duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <x-card x-cloak @click.outside="{{ $key }} = false"
        class="{{ $cardClass ?? 'bg-app-white dark:bg-app-slate-800 w-full sm:w-96' }}">
        {{ $slot }}
    </x-card>
</div>
