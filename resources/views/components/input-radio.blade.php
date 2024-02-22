<label
    {{ $attributes->merge([
        'class' =>
            'block cursor-pointer px-3 py-2 hover:bg-slate-100 rounded-md has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-900 border border-transparent has-[:checked]:border-indigo-500 mb-2',
    ]) }}>
    <input class="checked:border-indigo-500" type="radio" name="{{ $name }}" value="{{ $value }}"
        @if (old($name) === $value) checked @endif>
    {{ $value }}
</label>
@if (isset($name) && isset($error) && $error)
    @error($name)
        <div class="mt-2 text-sm text-rose-600">{{ $message }}</div>
    @enderror
@endif
