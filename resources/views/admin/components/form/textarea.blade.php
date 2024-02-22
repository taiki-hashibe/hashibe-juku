<div x-data="{
    resize: () => {
        $refs.contentTextarea.style.height = '5px';
        $refs.contentTextarea.style.height = $refs.contentTextarea.scrollHeight + 'px';
    }
}">
    <textarea x-ref="contentTextarea" x-init="resize()" @input="resize()"
        {{ $attributes->merge([
            'class' =>
                'w-full inline-block rounded-md border focus:outline-0 focus:border-purple-500 px-3 py-2 resize-none' .
                ($errors->first($name) !== '' ? ' border-rose-600' : ''),
        ]) }}
        name="{{ $name }}">{{ $slot }}</textarea>
</div>

@error($name)
    <div class="mt-2 text-sm text-rose-600">{{ $message }}</div>
@enderror
