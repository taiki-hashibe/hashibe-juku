<x-guest-layout class="bg-white">
    @if (isset($category))
        {{ Breadcrumbs::render(request()->route()->getName(), $post, $category) }}
    @else
        {{ Breadcrumbs::render(request()->route()->getName(), $post) }}
    @endif
    <x-horizontal-layout>
        <x-slot:main>
            <div class="mb-8">
                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4">{{ $post->title }}</h2>
                </div>
                @if ($post->public_release_at && $post->public_release_at->isAfter(now()))
                    <x-gradation-container class="md:hidden">
                        <p class=text-center>
                            このレッスンは<br class="md:hidden">{{ $post->public_release_at->format('Y年m月d日 H時i分') }}<br
                                class="md:hidden">に公開予定です。
                        </p>
                    </x-gradation-container>
                    <div class="mb-8">
                        <div class="w-full aspect-video rounded-md overflow-hidden relative">
                            <img class="w-full h-full object-cover" src="{{ $post->thumbnail() }}" alt="">
                            <div
                                class="w-full h-full absolute bg-black/75 top-0 left-0 flex justify-center items-center px-2">
                                <div class="text-white font-bold text-center">
                                    <p class="mb-4 hidden md:block">
                                        このレッスンは<br
                                            class="md:hidden">{{ $post->public_release_at->format('Y年m月d日 H時i分') }}<br
                                            class="md:hidden">に公開予定です。
                                    </p>
                                    <p class="mb-2">
                                        公式LINEを友達追加して先取り視聴しよう！
                                    </p>
                                    <a class="inline-block md:block px-6 py-2 rounded-full text-white outline-1 font-bold bg-line duration-200 hover:bg-line-active mb-6"
                                        href="{{ $post->line_link ?? config('line.link') }}">
                                        <div class="flex justify-center items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                class="w-5 h-5 me-3" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0ZM5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.154.154 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157Zm.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156h-.562Zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832a.17.17 0 0 0-.013-.015v-.001a.139.139 0 0 0-.01-.01l-.003-.003a.092.092 0 0 0-.011-.009h-.001L7.88 4.79l-.003-.002a.029.029 0 0 0-.005-.003l-.008-.005h-.002l-.003-.002-.01-.004-.004-.002a.093.093 0 0 0-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.154.154 0 0 0 .039.038l.001.001.01.006.004.002a.066.066 0 0 0 .008.004l.007.003.005.002a.168.168 0 0 0 .01.003h.003a.155.155 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156h-.561Zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.155.155 0 0 0-.108.044h-.001l-.001.002-.002.003a.155.155 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.155.155 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z" />
                                            </svg>
                                            <span>公式LINE</span>
                                        </div>
                                    </a>
                                    <a href="{{ $post->getRouteCategoryOrPost(true) }}" class="block underline">
                                        既に友達追加済みの方はこちら！
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <x-post-video :post="$post" />
                    @if ($post->video_free)
                        <x-add-official-line-navigation lineLink="{{ $post->line_link }}"
                            text="公式LINEを友達追加するとフルバージョンの動画が閲覧できます！" href="{{ $post->getRouteCategoryOrPost() }}" />
                    @endif
                    <div class="relative">
                        <x-post-content :post="$post" class="mb-8"
                            column="{{ $post->content_free ? 'content_free' : null }}" />
                        @if ($post->content || $post->content_free)
                            <div class="absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t via-white from-white">

                            </div>
                        @endif
                    </div>
                    @if ($post->content_free)
                        <x-add-official-line-navigation lineLink="{{ $post->line_link }}"
                            text="公式LINEを友達追加するとフルバージョンの記事が閲覧できます！" href="{{ $post->getRouteCategoryOrPost() }}" />
                    @endif
                @endif

                <x-post-navigation-buttons :post="$post" />
            </div>
        </x-slot:main>
        <x-slot:side>
            <x-same-category-list :post="$post" />
        </x-slot:side>
    </x-horizontal-layout>
</x-guest-layout>
