<x-layout class="bg-white">
    <x-horizontal-layout>
        <x-slot:main>
            <x-breadcrumb :post="$post" :category="isset($category) ? $category : null"></x-breadcrumb>
            <div class="mb-8">
                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4">{{ $post->title }}</h2>
                    @if ($post->isCanView())
                        {{-- <livewire:bookmark :post="$post" /> --}}
                    @endif
                </div>
                @if ($post->video_free)
                    <div class="mb-8">
                        <video id="video-js" class="video video-js" playsinline controls>
                            <source src="{{ $post->video_free }}">
                        </video>
                    </div>
                @elseif ($post->video)
                    <div class="mb-8">
                        <video id="video-js" class="video video-js" playsinline controls>
                            <source src="{{ $post->video }}">
                        </video>
                    </div>
                @endif
                @if ($post->video || $post->video_free)
                    <x-add-official-line-navigation text="公式LINEを友達追加するとフルバージョンの動画が閲覧できます！" />
                @endif
                <x-post-content :post="$post" class="mb-8"
                    column="{{ $post->content_free ? 'content_free' : null }}"></x-post-content>
                @if ($post->content_free)
                    <x-add-official-line-navigation text="公式LINEを友達追加するとフルバージョンの記事が閲覧できます！" />
                @endif
                <x-post-navigation-buttons :post="$post" />
            </div>
        </x-slot:main>
        <x-slot:side>
            <x-same-category-list :post="$post" />
        </x-slot:side>
    </x-horizontal-layout>
</x-layout>
