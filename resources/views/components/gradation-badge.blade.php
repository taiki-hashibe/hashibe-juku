<p
    {{ $attributes->merge([
        'class' =>
            'inline-block me-2 mb-4 px-2 text-xl text-nowrap rounded-sm text-white outline font-bold bg-gradient-to-r from-orange-600 to-pink-500',
    ]) }}>
    {{ $slot }}
</p>
