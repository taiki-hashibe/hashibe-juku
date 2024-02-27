@unless ($breadcrumbs->isEmpty())
    <nav class="mb-6">
        <ol>
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li class="inline">
                        <a href="{{ $breadcrumb->url }}"
                            class="text-blue-500 dark:text-white hover:text-blue-700  dark:hover:text-white underline text-sm">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li class="inline text-slate-500 dark:text-slate-100 text-sm">
                        {{ $breadcrumb->title }}
                    </li>
                @endif

                @unless ($loop->last)
                    <li class="inline mx-1 text-slate-500 dark:text-slate-100 text-sm">
                        /
                    </li>
                @endif
                @endforeach
            </ol>
        </nav>
    @endunless
