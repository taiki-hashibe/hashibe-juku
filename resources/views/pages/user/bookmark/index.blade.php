<x-layout class="bg-white">
    <x-breadcrumb :post="null" :category="null" :curriculum="null" :item="[
        'label' => 'ブックマーク',
        'url' => route('user.bookmark'),
    ]" />
    @if ($posts->get()->count() > 0)
        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-14">
            @foreach ($posts->get() as $item)
                <li>
                    <div class="block px-4 pt-4 pb-6 rounded-md">
                        <a href="{{ route('post.post', [
                            'post' => $item->slug,
                        ]) }}"
                            class="block group w-full aspect-video overflow-hidden rounded-md mb-4">
                            <img class="w-full h-full object-cover duration-200 group-hover:scale-110"
                                src="{{ $item->thumbnail() }}" alt="">
                        </a>
                        <div>
                            <p class="font-bold mb-2 truncate">{{ $item->title }}</p>
                            <p class="whitespace-pre-line line-clamp-4 mb-4">{{ $item->getDescription() }}
                            </p>
                            <x-gradation-anchor
                                href="{{ route('user.post.post', [
                                    'post' => $item->slug,
                                ]) }}">
                                受講する！
                            </x-gradation-anchor>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="flex flex-col items-center font-bold text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" data-slot="icon" class="w-8 h-8 mb-3">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
            </svg>
            <span class="text-sm">
                ブックマークしたレッスンはありません
            </span>
        </div>
    @endif
</x-layout>
