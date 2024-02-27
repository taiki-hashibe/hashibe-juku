<ul>
    @foreach ($curriculum->posts as $item)
        <li class="mb-2">
            @if ($item->id === $post->id)
                <p class="block truncate px-4 py-3 rounded-md bg-indigo-50">
                    {{ $item->title }}
                </p>
            @else
                <a href="{{ route('user.curriculum.post', [
                    'curriculum' => $curriculum->slug,
                    'post' => $item->slug,
                ]) }}"
                    class="block truncate px-4 py-3 rounded-md duration-100 hover:bg-slate-100">
                    {{ $item->title }}
                </a>
            @endif
        </li>
    @endforeach
</ul>
