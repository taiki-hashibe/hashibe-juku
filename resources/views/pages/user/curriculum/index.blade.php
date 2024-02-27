<x-layout class="bg-white">
    <x-breadcrumb :post="null" :category="null" :curriculum="$curriculum" />
    <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
        {{ $curriculum->name }}
    </h2>
    <p class="text-slate-800 ps-4 mb-8">
        {{ $curriculum->description }}
    </p>
    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-14">
        @foreach ($curriculum->posts as $item)
            <li>
                <div class="block px-4 pt-4 pb-6 rounded-md">
                    <a href="{{ route('user.curriculum.post', [
                        'curriculum' => $curriculum->slug,
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
                            href="{{ route('user.curriculum.post', [
                                'curriculum' => $curriculum->slug,
                                'post' => $item->slug,
                            ]) }}">
                            受講する！
                        </x-gradation-anchor>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</x-layout>
