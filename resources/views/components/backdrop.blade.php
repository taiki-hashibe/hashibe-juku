<div x-cloak x-transition:enter="transition liner duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition liner duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    {{ $attributes->merge([
        'class' => 'z-40 fixed top-0 left-0 w-screen h-screen bg-black/50',
    ]) }}>

</div>
