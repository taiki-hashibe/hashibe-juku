<div
    {{ $attributes->merge([
        'class' => 'px-4 pt-4 pb-6 shadow-md rounded-md border border-app-slate-300',
    ]) }}>
    {{ $slot }}
</div>
