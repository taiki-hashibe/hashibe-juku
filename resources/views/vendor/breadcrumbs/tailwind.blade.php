@unless ($breadcrumbs->isEmpty())
    <nav class="mb-6">
        <ol>
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li class="inline">
                        <a href="{{ $breadcrumb->url }}" class="text-slate-500 hover:text-slate-800 underline text-sm">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li class="inline text-slate-500 text-sm">
                        {{ $breadcrumb->title }}
                    </li>
                @endif

                @unless ($loop->last)
                    <li class="inline mx-1 text-slate-500 text-sm">
                        /
                    </li>
                @endif
                @endforeach
            </ol>
        </nav>
    @endunless
