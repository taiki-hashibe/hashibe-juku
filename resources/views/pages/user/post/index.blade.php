<x-layout class="bg-white">
    @if (!$post->isCanView())
        <x-user-trial-viewing-post-modal :post="$post" />
    @endif
    <x-horizontal-layout>
        <x-slot:main>
            <x-breadcrumb :post="$post" :category="isset($category) ? $category : null" :curriculum="null"></x-breadcrumb>
            <div class="mb-8">
                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4">{{ $post->title }}</h2>
                </div>
                <x-post-video :post="$post" />
                @if (!$post->isCanView() && ($post->video || $post->video_free))
                    <x-user-trial-viewing-post-navigation :post="$post" text="トライアルチケットを使ってフルバージョンの動画を見ることができます！" />
                @endif
                @if (auth('users')->user()->subscribed('online-salon'))
                    <div class="flex">
                        <livewire:bookmark :post="$post" />
                        <livewire:complete :post="$post" />
                    </div>
                @endif
                <x-post-content :post="$post" class="mb-8" />
                @if (!$post->isCanView() && ($post->content || $post->content_free))
                    <x-user-trial-viewing-post-navigation :post="$post" text="トライアルチケットを使ってフルバージョンの記事を見ることができます！" />
                @endif
                <x-post-navigation-buttons :post="$post" />
            </div>
        </x-slot:main>
        <x-slot:side>
            <x-same-category-list :post="$post" />
        </x-slot:side>
    </x-horizontal-layout>
</x-layout>
