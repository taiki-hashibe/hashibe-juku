<x-guest-layout class="bg-white">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 md:col-span-9 w-full">
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
                    <x-gradation-container>
                        <div class="flex flex-col items-center">
                            <p class="mb-4">公式LINEを友達追加するとフルバージョンの動画が閲覧できます！</p>
                            <a class="inline-block px-6 py-2 text-white outline-1 font-bold bg-line rounded-full duration-200 hover:bg-line-active"
                                href="{{ config('line.link') }}">
                                <div class="flex justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 me-3"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0ZM5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.154.154 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157Zm.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156h-.562Zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832a.17.17 0 0 0-.013-.015v-.001a.139.139 0 0 0-.01-.01l-.003-.003a.092.092 0 0 0-.011-.009h-.001L7.88 4.79l-.003-.002a.029.029 0 0 0-.005-.003l-.008-.005h-.002l-.003-.002-.01-.004-.004-.002a.093.093 0 0 0-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.154.154 0 0 0 .039.038l.001.001.01.006.004.002a.066.066 0 0 0 .008.004l.007.003.005.002a.168.168 0 0 0 .01.003h.003a.155.155 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156h-.561Zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.155.155 0 0 0-.108.044h-.001l-.001.002-.002.003a.155.155 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.155.155 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z" />
                                    </svg>
                                    <span>公式LINEを友達追加する！</span>
                                </div>
                            </a>
                        </div>
                    </x-gradation-container>
                @endif
                <x-post-content :post="$post" class="mb-8"
                    column="{{ $post->content_free ? 'content_free' : null }}"></x-post-content>
                @if ($post->content_free)
                    <x-gradation-container>
                        <div class="flex flex-col items-center">
                            <p class="mb-4">公式LINEを友達追加するとフルバージョンの記事が閲覧できます！</p>
                            <a class="inline-block px-6 py-2 text-white outline-1 font-bold bg-line rounded-full duration-200 hover:bg-line-active"
                                href="{{ config('line.link') }}">
                                <div class="flex justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 me-3"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0ZM5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.154.154 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157Zm.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156h-.562Zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832a.17.17 0 0 0-.013-.015v-.001a.139.139 0 0 0-.01-.01l-.003-.003a.092.092 0 0 0-.011-.009h-.001L7.88 4.79l-.003-.002a.029.029 0 0 0-.005-.003l-.008-.005h-.002l-.003-.002-.01-.004-.004-.002a.093.093 0 0 0-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.154.154 0 0 0 .039.038l.001.001.01.006.004.002a.066.066 0 0 0 .008.004l.007.003.005.002a.168.168 0 0 0 .01.003h.003a.155.155 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156h-.561Zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.155.155 0 0 0-.108.044h-.001l-.001.002-.002.003a.155.155 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.155.155 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z" />
                                    </svg>
                                    <span>公式LINEを友達追加する！</span>
                                </div>
                            </a>
                        </div>
                    </x-gradation-container>
                @endif
                <div class="flex justify-between">
                    <div class="w-1/3">
                        @if ($prev)
                            <p class="text-xs md:text-sm mb-1 md:ps-2">前のレッスン</p>
                            <a href="{{ $prev->category
                                ? route('post.category', [
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
                                ? route('post.category', [
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
        <div class="hidden md:block col-span-3">
            <ul>
                @foreach ($post->getInTheSameCategory()->get() as $item)
                    <li class="mb-2">
                        @if ($item->id === $post->id)
                            <p class="block truncate px-4 py-3 rounded-md bg-indigo-50">
                                {{ $item->title }}
                            </p>
                        @else
                            <a href="{{ $item->category
                                ? route('post.category', [
                                    'post' => $item->slug,
                                    'category' => $item->category->slug,
                                ])
                                : route('post.post', [
                                    'post' => $item->slug,
                                ]) }}"
                                class="block truncate px-4 py-3 rounded-md duration-100 hover:bg-slate-100">
                                {{ $item->title }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-guest-layout>
