<x-auth-layout class="bg-white">
    {{ Breadcrumbs::render(request()->route()->getName()) }}
    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-14">
        @foreach ($posts as $item)
            <li>
                <x-post-list-item :post="$item"
                    href="{{ route('user.post.post', [
                        'post' => $item->slug,
                    ]) }}" />
            </li>
        @endforeach
    </ul>
    @if ($categories->get()->count() > 0)
        <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
            カテゴリーから探す
        </h2>
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
    @endif

    @if ($curriculums->get()->count() > 0)
        <h2 class="font-bold text-slate-800 text-xl ps-4 mb-4">
            カリキュラムから探す
        </h2>
        <ul class="mb-14">
            @foreach ($curriculums->get() as $item)
                <li>
                    <x-curriculum-list-item :curriculum="$item"
                        href="{{ route('user.curriculum.index', [
                            'curriculum' => $item->slug,
                        ]) }}" />
                </li>
            @endforeach
        </ul>
    @endif
</x-auth-layout>
