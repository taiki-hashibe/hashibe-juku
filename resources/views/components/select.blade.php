<select
    {{ $attributes->merge([
        'class' =>
            'block w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none forcus:border-2 focus:border-purple-500',
    ]) }}>
    {{ $slot }}
</select>
