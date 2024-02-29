<nav>
    <ul class="flex justify-between">
        <li class="w-1/3">
            @if ($prev)
                <p class="text-xs md:text-sm mb-1 md:ps-2">前のレッスン</p>
                <a href="{{ $prev->getRouteCategoryOrPost($auth) }}"
                    class="block w-full truncate underline">{{ $prev->title }}</a>
            @endif
        </li>
        <li class="w-1/3">
            @if ($next)
                <p class="text-xs md:text-sm text-end mb-1 md:ps-2">次のレッスン</p>
                <a href="{{ $next->getRouteCategoryOrPost($auth) }}"
                    class="block w-full truncate underline text-end">{{ $next->title }}</a>
            @endif
        </li>
    </ul>
</nav>
