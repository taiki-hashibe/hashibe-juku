<x-guest-layout class="bg-white">
    <div class="w-full flex justify-center">
        <div class="mb-8">
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-4">{{ $post->title }}</h2>
                @if ($post->isCanView())
                    {{-- <livewire:bookmark :post="$post" /> --}}
                @endif
            </div>
            @if ($post->video)
                <div class="mb-8">
                    <video id="video-js" class="video video-js" playsinline controls>
                        <source src="{{ $post->video }}">
                    </video>
                </div>
            @endif
            <x-post-content :post="$post" class="mb-8"></x-post-content>
            <div class="flex justify-between">
                <div class="w-1/3">
                    @if ($prev)
                        <p class="text-xs md:text-sm mb-1 md:ps-2">前のレッスン</p>
                        <a href="{{ $prev->category
                            ? route('content.post', [
                                'category' => $prev->category->slug,
                                'post' => $prev->slug,
                            ])
                            : route('post.post', [
                                'post' => $prev->slug,
                            ]) }}"
                            class="block w-full truncate underline">{{ $prev->title }}</a>
                    @endif
                </div>
                <div class="w-1/3">
                    @if ($next)
                        <p class="text-xs md:text-sm text-end mb-1 md:ps-2">次のレッスン</p>
                        <a href="{{ $next->category
                            ? route('content.post', [
                                'category' => $next->category->slug,
                                'post' => $next->slug,
                            ])
                            : route('post.post', [
                                'post' => $next->slug,
                            ]) }}"
                            class="block w-full truncate underline text-end">{{ $next->title }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
