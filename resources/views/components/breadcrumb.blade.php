<nav class="mb-6">
    <ul>
        @foreach ($breadcrumbs as $i => $breadcrumb)
            @if (array_key_exists('url', $breadcrumb) && $breadcrumb['url'])
                <li class="inline">
                    <a href="{{ $breadcrumb['url'] }}"
                        class="text-primary-500 dark:text-white hover:text-primary-700  dark:hover:text-white underline text-sm">{{ $breadcrumb['label'] }}</a>
                </li>
            @else
                <li class="inline">
                    <span class="text-slate-500 dark:text-slate-100 text-sm">{{ $breadcrumb['label'] }}</span>
                </li>
            @endif
            @if ($i < count($breadcrumbs) - 1)
                <li class="inline">
                    <span class="mx-1 text-slate-500 dark:text-slate-100 text-sm">/</span>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
