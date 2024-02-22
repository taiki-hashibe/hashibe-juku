<th
    {{ $attributes->merge([
        'class' =>
            'border-b dark:border-slate-600 font-medium p-3 pl-6 pt-0 pb-3 text-slate-600 whitespace-nowrap dark:text-slate-200 text-left text-xs',
    ]) }}>
    {{ $slot }}
</th>
