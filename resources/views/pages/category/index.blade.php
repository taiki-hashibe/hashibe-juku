<x-guest-layout class="bg-white">
    <x-breadcrumb :post="null" :category="isset($category) ? $category : null" />
    <ul class="grid grid-cols-3 gap-4 mb-8">
        @foreach ($posts as $item)
            <li>
                <div class="block px-4 pt-4 pb-6 rounded-md">
                    <a href="{{ route('post.post', [
                        'post' => $item->slug,
                    ]) }}"
                        class="block group w-full aspect-video overflow-hidden rounded-md mb-4">
                        <img class="w-full object-cover duration-200 group-hover:scale-110"
                            src="https://i.ytimg.com/vi/07qWzWJktT8/hqdefault.jpg?sqp=-oaymwEbCKgBEF5IVfKriqkDDggBFQAAiEIYAXABwAEG&rs=AOn4CLC0QUqEdWG5hwulQ9eqLinfcUYK2Q"
                            alt="">
                    </a>
                    <div>
                        <p class="font-bold mb-2 truncate">{{ $item->title }}</p>
                        <p class="whitespace-pre-line line-clamp-4 mb-4">{{ $item->getDescription() }}
                        </p>
                        <a href="{{ route('post.post', [
                            'post' => $item->slug,
                        ]) }}"
                            class="w-40 text-center block px-4 py-2 rounded-full text-white outline font-bold bg-gradient-to-r from-orange-600 to-pink-500 duration-200 hover:text-orange-500 hover:from-white hover:to-white hover:outline-1 hover:outline-orange-500 me-4">
                            受講する！
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @foreach ($categories->paginate(24) as $item)
        <div x-data
            class='{{ 'p-0.5 shadow-lg rounded-lg mb-6 bg-gradient-to-r from-orange-300 via-pink-500 to-blue-400' }}'>
            <div class="bg-white px-4 pt-4 pb-6 rounded-md flex">
                <div class="me-6">
                    <div class="w-40 aspect-video overflow-hidden rounded-md">
                        <img class="w-full object-cover"
                            src="https://i.ytimg.com/vi/07qWzWJktT8/hqdefault.jpg?sqp=-oaymwEbCKgBEF5IVfKriqkDDggBFQAAiEIYAXABwAEG&rs=AOn4CLC0QUqEdWG5hwulQ9eqLinfcUYK2Q"
                            alt="">
                    </div>
                </div>
                <div class="grow basis-0">
                    <h3 class="text-2xl font-bold mb-4">{{ $item->name }}
                    </h3>
                    <p class="text-xl text-slate-600 mb-4">
                    <div class="mb-4">
                        @if ($item->description)
                            <p class="whitespace-pre-line">{{ $item->description }}</p>
                        @endif
                    </div>
                    <div class="flex">
                        <div>
                            <a href="{{ route('category.detail', [
                                'category' => $item->slug,
                            ]) }}"
                                class="w-40 text-center block px-4 py-2 rounded-full text-white outline font-bold bg-gradient-to-r from-orange-600 to-pink-500 duration-200 hover:text-orange-500 hover:from-white hover:to-white hover:outline-1 hover:outline-orange-500 me-4">
                                受講する！
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-guest-layout>
