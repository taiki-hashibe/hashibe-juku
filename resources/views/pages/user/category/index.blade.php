<x-guest-layout class="bg-white">
    {{ Breadcrumbs::render(request()->route()->getName(), $category) }}
    <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
        {{ $category->name }}
    </h2>
    <p class="text-slate-800 ps-4 mb-8">
        {{ $category->description }}
    </p>
    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-14">
        @foreach ($posts as $item)
            <li>
                <x-post-list-item :post="$item"
                    href="{{ route('user.post.category', [
                        'post' => $item->slug,
                        'category' => $category->slug,
                    ]) }}" />
            </li>
        @endforeach
    </ul>
    <ul class="mb-14">
        @foreach ($categories->get() as $item)
            <li>
                <x-category-list-item :category="$item"
                    href="{{ route('user.category.index', [
                        'category' => $item->slug,
                    ]) }}" />
            </li>
        @endforeach
    </ul>
</x-guest-layout>
