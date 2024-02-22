<label {{ $attributes->merge([
    'class' => 'block pt-2 ps-3 font-bold mb-2',
]) }}>
    @if (isset($required) && $required)
        <span class="text-sm px-1 bg-red-100 text-red-900 me-2">
            必須
        </span>
    @else
        <span class="text-sm px-1 bg-green-100 text-green-900 me-2">
            任意
        </span>
    @endif
    {{ $slot }}
    @if (isset($error))
        @error($error)
            <div class="mt-2 text-sm text-rose-600">{{ $message }}</div>
        @enderror
    @endif
</label>
