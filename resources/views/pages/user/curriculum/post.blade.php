<x-layout class="bg-white">
    <x-horizontal-layout>
        <x-slot:main>
            <x-breadcrumb :post="$post" :category="null" :curriculum="$curriculum"></x-breadcrumb>
            <div class="mb-8">
                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4">{{ $post->title }}</h2>
                </div>
                <x-post-video :post="$post" />
                @if (auth('users')->user()->subscribed('online-salon'))
                    <div class="flex">
                        <livewire:bookmark :post="$post" />
                        <livewire:complete :post="$post" />
                    </div>
                @endif
                <x-post-content :post="$post" class="mb-8" />
                <x-post-navigation-buttons :post="$post" />
            </div>
        </x-slot:main>
        <x-slot:side>
            <x-same-curriculum-list :curriculum="$curriculum" :post="$post" />
        </x-slot:side>
    </x-horizontal-layout>
</x-layout>
