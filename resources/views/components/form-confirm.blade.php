<div {{ $attributes->merge([
    'class' => 'block px-3 py-2 rounded-md bg-slate-100',
]) }}>
    {{ $slot }}
</div>
