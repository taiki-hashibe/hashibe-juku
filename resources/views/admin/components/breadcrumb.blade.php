<div class="flex justify-between px-8 mb-8">
    <ul class="flex items-center">
        @foreach ($pages as $i => $page)
            @if (isset($page['href']))
                <li>
                    <a href="{{ $page['href'] }}" class="block text-slate-500 font-bold truncate max-w-32">
                        {{ $page['label'] }}
                    </a>
                </li>
            @else
                <li>
                    <span class="block text-lg font-bold truncate max-w-32">
                        {{ $page['label'] }}
                    </span>
                </li>
            @endif
            @if (count($pages) > $i + 1)
                <li><span class="block text-slate-500 font-bold truncate max-w-32 mx-3">/</span></li>
            @endif
        @endforeach
    </ul>
    {{ $slot }}
</div>
