@if ($post->tags->count() > 0)
    <ul class="mb-8">
        @foreach ($post->tags as $tag)
            <li class="inline text-sm me-1 mb-1 bg-slate-200 px-2">
                <a
                    href="{{ $auth
                        ? route('user.tag', [
                            'tag' => $tag->slug,
                        ])
                        : route('tag.index', [
                            'tag' => $tag->slug,
                        ]) }}">
                    {{ $tag->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
