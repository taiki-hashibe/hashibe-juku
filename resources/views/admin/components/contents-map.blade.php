<ul class="pt-2 mb-2 list-disc list-inside{{ $isParent ? '' : ' ps-4' }}">
    @if ($posts)
        @foreach ($posts as $post)
            <li class="py-1 mb-1 border-t first:border-none">
                <span class="me-4">{{ $post->title }}</span>
                <a href="{{ route('admin.post.show', [
                    'post' => $post->id,
                ]) }}"
                    class="text-sm text-gray-400 hover:text-gray-500 hover:underline me-2">詳細</a>
                <a href="{{ route('admin.post.edit', [
                    'post' => $post->id,
                ]) }}"
                    class="text-sm text-gray-400 hover:text-gray-500 hover:underline">編集</a>
            </li>
        @endforeach
    @endif
    @if ($categories)
        @foreach ($categories as $category)
            <li class="ps-4 py-1 mb-1 list-none relative">
                <div class="absolute left-0 w-1 contents-map-line top-5 {{ $lineColor }} rounded-md"></div>
                <p class="mt-2 flex items-center">
                    <span class="me-4">{{ $category->name }}</span>
                    <a href="{{ route('admin.category.show', [
                        'category' => $category->id,
                    ]) }}"
                        class="text-sm text-gray-400 hover:text-gray-500 hover:underline me-2">詳細</a>
                    <a href="{{ route('admin.category.edit', [
                        'category' => $category->id,
                    ]) }}"
                        class="text-sm text-gray-400 hover:text-gray-500 hover:underline">編集</a>
                </p>
                <x-admin.contents-map :nest="$nest + 1" :categories="$category->children" :posts="$category
                    ->posts()
                    ->publish()
                    ->get()"></x-admin.contents-map>
            </li>
        @endforeach
    @endif
</ul>
