<input
    {{ $attributes->merge([
        'class' =>
            'w-full inline-block rounded-md border duration-100 focus:outline-0 focus:border-purple-500 px-3 py-2' .
            ($errors->first($name) !== '' ? ' border-rose-600' : ''),
    ]) }}
    name="{{ $name }}">

@error($name)
    <div class="mt-2 text-sm text-rose-600">{{ $message }}</div>
@enderror
