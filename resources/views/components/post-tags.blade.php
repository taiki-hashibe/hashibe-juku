@if ($post->tags->count() > 0)
    <ul class="mb-8">
        @foreach ($post->tags as $tag)
            <li class="inline text-sm me-1 mb-1 bg-slate-200 px-2">
                {{ $tag->name }}
            </li>
        @endforeach
    </ul>
@endif
