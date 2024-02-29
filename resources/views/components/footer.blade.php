<footer class="px-6 md:px-10 py-12 bg-slate-200">
    <p class="mb-8">
        <x-logo class="h-16 py-3 opacity-75"></x-logo>
    </p>
    <ul class="flex text-slate-700 mb-12">
        <li><a href="{{ config('line.link') }}">公式LINE</a></li>
    </ul>
    <ul class="text-slate-700 text-sm mb-6">
        @foreach ($pages as $item)
            <li class="mb-1"><a
                    href="{{ route('page', [
                        'page' => $item->slug,
                    ]) }}">{{ $item->title }}</a>
            </li>
        @endforeach
    </ul>
    <p class="text-sm text-slate-700">&copy;{{ config('app.name') }}2023</p>
</footer>
