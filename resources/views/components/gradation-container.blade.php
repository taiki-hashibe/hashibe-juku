<div
    {{ $attributes->merge([
        'class' => 'p-0.5 shadow-lg rounded-lg mb-6 bg-gradient-to-r from-orange-300 via-pink-500 to-blue-400',
    ]) }}>
    <div class="bg-white px-4 pt-4 pb-6 rounded-md {{ isset($innerClass) ? ' ' . $innerClass : '' }}">
        {{ $slot }}
    </div>
</div>
