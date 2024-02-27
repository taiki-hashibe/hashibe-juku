<div
    {{ $attributes->merge([
        'class' => 'p-0.5 bg-gradient-to-r from-orange-300 via-pink-500 to-blue-400',
    ]) }}>
    <div class="bg-white {{ isset($innerClass) ? ' ' . $innerClass : '' }}">
        {{ $slot }}
    </div>
</div>
