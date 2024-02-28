<x-layout class="bg-white">
    {{ Breadcrumbs::render(request()->route()->getName(), $curriculum, $post) }}
    <x-horizontal-layout>
        <x-slot:main>
            <div class="mb-8">
                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4">{{ $post->title }}</h2>
                </div>
                <x-post-video :post="$post" />
                <div class="flex">
                    <livewire:bookmark :post="$post" />
                    <livewire:complete :post="$post" />
                </div>
                <x-post-content :post="$post" class="mb-8" />
                <x-post-navigation-buttons :post="$post" />
            </div>
        </x-slot:main>
        <x-slot:side>
            <x-same-curriculum-list :curriculum="$curriculum" :post="$post" />
        </x-slot:side>
    </x-horizontal-layout>
</x-layout>
