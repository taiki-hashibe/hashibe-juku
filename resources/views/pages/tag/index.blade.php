<x-layout class="bg-white">
    {{ Breadcrumbs::render(request()->route()->getName(), $tag) }}
    <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
        {{ $tag->name }}
    </h2>
    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-14">
        @foreach ($posts as $item)
            <li>
                <x-post-list-item :post="$item" href="{{ $item->getRouteCategoryOrPost() }}" />
            </li>
        @endforeach
    </ul>
</x-layout>
