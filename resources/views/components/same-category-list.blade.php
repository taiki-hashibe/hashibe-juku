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
