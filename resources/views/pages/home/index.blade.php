<x-guest-layout class="bg-white" :guest="true">
    {{ Breadcrumbs::render(request()->route()->getName()) }}
    @if ($posts->count() > 0)
        <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">最初に見てほしい記事</h2>
        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-14">
            @foreach ($posts as $item)
                <li>
                    <x-post-list-item :post="$item" />
                </li>
            @endforeach
        </ul>
    @endif
    @if ($categories->get()->count() > 0)
        <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
            カテゴリーから探す
        </h2>
        <ul class="mb-14">
            @foreach ($categories->get() as $item)
                <li>
                    <x-category-list-item :category="$item" />
                </li>
            @endforeach
        </ul>
    @endif

    @if ($curriculums->get()->count() > 0)
        <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
            カリキュラムから探す
        </h2>
        <ul class="mb-14">
            @foreach ($curriculums->get() as $item)
                <li>
                    <x-curriculum-list-item :curriculum="$item" />
                </li>
            @endforeach
        </ul>
    @endif

    @if ($posts->count() === 0 && $categories->get()->count() === 0 && $curriculums->get()->count() === 0)
        <div class="w-full flex justify-center mt-8">
            <div class="flex flex-col items-center">
                <a class="block aspect-square overflow-hidden rounded-full w-32 mb-8 border"
                    href="{{ config('line.link') }}">
                    <img src="{{ asset('images/line-icon.png') }}" alt="">
                </a>
                <a class="block px-6 py-2 text-white outline-1 font-bold bg-line duration-200 hover:bg-line-active"
                    href="{{ config('line.link') }}">
                    <div class="flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 me-3"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0ZM5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.154.154 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157Zm.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156h-.562Zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832a.17.17 0 0 0-.013-.015v-.001a.139.139 0 0 0-.01-.01l-.003-.003a.092.092 0 0 0-.011-.009h-.001L7.88 4.79l-.003-.002a.029.029 0 0 0-.005-.003l-.008-.005h-.002l-.003-.002-.01-.004-.004-.002a.093.093 0 0 0-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.154.154 0 0 0 .039.038l.001.001.01.006.004.002a.066.066 0 0 0 .008.004l.007.003.005.002a.168.168 0 0 0 .01.003h.003a.155.155 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156h-.561Zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.155.155 0 0 0-.108.044h-.001l-.001.002-.002.003a.155.155 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.155.155 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z" />
                        </svg>
                        <span>公式LINE</span>
                    </div>
                </a>
            </div>
        </div>
    @endif
</x-guest-layout>
