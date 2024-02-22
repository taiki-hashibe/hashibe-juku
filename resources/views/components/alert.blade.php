<div x-data="{ open: true }" x-show="open" {{ $attributes->merge([
    'class' => 'relative mb-3 text-sm',
]) }}>
    <div class="w-full flex items-center justify-between px-5 py-3 rounded-md border {{ $containerClass }}">
        <div>
            @isset($title)
                <p class="flex items-center font-bold @if ($message) mb-2 @endif {{ $titleClass }}">
                    @isset($icon)
                        <span class="{{ $svgClass }}">{!! $icon !!}</span>
                        @endisset{{ $title }}
                    </p>
                @endisset
                @isset($message)
                    <p class="{{ $messageClass }}">{!! $message !!}</p>
                @endisset
            </div>
            <button x-on:click="{{ $closeCallback }}" class="p-1" type="button">
                <span class="{{ $svgClass }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </button>
        </div>
    </div>
