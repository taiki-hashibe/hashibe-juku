<x-layout class="bg-white">
    <x-breadcrumb :post="null" :category="isset($category) ? $category : null" />
    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        @foreach ($posts as $item)
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
    <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
        カリキュラムから探す
    </h2>
    <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
        カテゴリーから探す
    </h2>
    @foreach ($categories->get() as $item)
        <div x-data
            class='{{ 'p-0.5 shadow-lg rounded-lg mb-6 bg-gradient-to-r from-orange-300 via-pink-500 to-blue-400' }}'>
            <div class="bg-white px-4 pt-4 pb-6 rounded-md flex">
                <div class="me-6 flex flex-col items-center relative w-28 md:w-40">
                    <div class="w-11/12 aspect-video rounded-md bg-slate-300 absolute -translate-y-2">

                    </div>
                    <div class="w-full aspect-video rounded-md z-10">
                        <img class="w-full h-full object-cover aspect-video rounded-md" src="{{ $item->thumbnail() }}"
                            alt="">
                    </div>
                </div>
                <div class="grow basis-0">
                    <h3 class="line-clamp-3 md:line-clamp-none md:text-2xl font-bold mb-4">{{ $item->name }}
                    </h3>
                    <div class="mb-4 hidden sm:block">
                        @if ($item->description)
                            <p class="whitespace-pre-line">{{ $item->description }}</p>
                        @endif
                    </div>
                    <div class="flex">
                        <div>
                            <x-gradation-anchor
                                href="{{ route('user.category.index', [
                                    'category' => $item->slug,
                                ]) }}">
                                受講する！
                            </x-gradation-anchor>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-layout>
