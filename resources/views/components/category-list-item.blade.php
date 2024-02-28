<x-gradation-container innerClass="flex">
    <div class="me-6 flex flex-col items-center relative w-28 md:w-40">
        <div class="w-11/12 aspect-video rounded-md bg-slate-300 absolute -translate-y-2">

        </div>
        <div class="w-full aspect-video rounded-md z-10">
            <img class="w-full h-full object-cover aspect-video rounded-md" src="{{ $category->thumbnail() }}"
                alt="">
        </div>
    </div>
    <div class="grow basis-0">
        <h3 class="line-clamp-3 md:line-clamp-none md:text-2xl font-bold mb-4">{{ $category->name }}
        </h3>
        <div class="mb-4 hidden sm:block">
            @if ($category->description)
                <p class="whitespace-pre-line">{{ $category->description }}</p>
            @endif
        </div>
        <div class="flex">
            <div>
                <x-gradation-anchor
                    href="{{ isset($href)
                        ? $href
                        : route('category.index', [
                            'category' => $category->slug,
                        ]) }}">
                    受講する！
                </x-gradation-anchor>
            </div>
        </div>
    </div>
</x-gradation-container>
