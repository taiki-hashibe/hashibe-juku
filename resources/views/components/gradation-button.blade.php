<button
    {{ $attributes->merge([
        'class' =>
            'inline-block text-nowrap px-8 py-2 rounded-full text-white outline font-bold bg-gradient-to-r from-orange-600 to-pink-500 duration-200 hover:text-orange-500 hover:from-white hover:to-white hover:outline-1 hover:outline-orange-500',
    ]) }}>
    {{ $slot }}
</button>
