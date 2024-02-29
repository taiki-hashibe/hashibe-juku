@php
    $href = isset($href)
        ? $href
        : route('post.post', [
            'post' => $post->slug,
        ]);
@endphp
<div class="block px-4 pt-4 pb-6 rounded-md">
    <a href="{{ $href }}" class="block group w-full aspect-video overflow-hidden rounded-md mb-4">
        <img class="w-full h-full object-cover duration-200 group-hover:scale-110" src="{{ $post->thumbnail() }}"
            alt="">
    </a>
    <div>
        <h3 class="font-bold mb-2 truncate">{{ $post->title }}</h3>
        <p class="whitespace-pre-line line-clamp-4 mb-4">{{ $post->getDescription() }}
        </p>
        <x-gradation-anchor href="{{ $href }}">
            受講する！
        </x-gradation-anchor>
    </div>
</div>
