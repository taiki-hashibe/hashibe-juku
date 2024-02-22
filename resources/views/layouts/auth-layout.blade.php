<!DOCTYPE html>
<html lang="ja">

<head>
    @if (config('app.env') === 'production')
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-BS77MN8B4K"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-BS77MN8B4K');
        </script>
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    @vite('resources/ts/app.ts')
    {!! SEO::generate() !!}
    @livewireStyles
</head>

<body class="min-h-screen text-app-color">
    <h1 class="hidden">{{ config('app.name') }}</h1>
    <div class="flex w-full min-h-screen">
        <nav class="sticky top-0 hidden md:block md:w-72 px-3 pb-4 md:pt-3 border-e h-screen">
            <div class="flex flex-col justify-between w-full h-full">
                <div>
                    <div class="mb-4 py-8">
                        <a href="{{ route('home') }}" aria-label="マイページトップ">
                            <x-logo class="md:ps-4 h-12 py-3"></x-logo>
                        </a>
                    </div>
                    <ul>
                        @foreach ($navigation as $nav)
                            <li class="mb-3">
                                <a href="{{ $nav['url'] }}"
                                    class="w-full px-4 py-2 flex items-center rounded-md duration-100 hover:bg-slate-100">
                                    {!! $nav['icon'] !!}
                                    <span
                                        class="font-semibold {{ $nav['active'] ? 'text-purple-800' : '' }}">{{ $nav['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                        @if (auth()->user()->admin)
                            @foreach ($adminNavigation as $nav)
                                <li class="mb-3">
                                    <a href="{{ $nav['url'] }}"
                                        class="w-full px-4 py-2 flex items-center rounded-md duration-100 hover:bg-slate-100">
                                        {!! $nav['icon'] !!}
                                        <span
                                            class="font-semibold {{ $nav['active'] ? 'text-purple-800' : '' }}">{{ $nav['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div>
                    <ul>
                        @foreach ($subNavigation as $nav)
                            <li class="mb-3">
                                <a href="{{ $nav['url'] }}"
                                    class="w-full px-4 py-2 flex items-center rounded-md duration-100 hover:bg-slate-100">
                                    {!! $nav['icon'] !!}
                                    <span
                                        class="font-semibold {{ $nav['active'] ? 'text-purple-800' : '' }}">{{ $nav['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
        <section class="w-full">
            <header
                class="fixed top-0 z-40 md:z-auto md:static md:top-auto w-full bg-white border-b mb-4 md:mb-0 md:border-0 px-6 md:px-10 py-4 md:py-6">
                <nav x-data="{ open: false }" class="flex justify-between items-center md:justify-end">
                    <a href="{{ route('home') }}" class="md:hidden">
                        <x-logo class="h-6 md:h-12"></x-logo>
                    </a>
                    <a href="{{ route('profile') }}" class="hidden md:flex items-center">
                        <div class="w-9 h-9 rounded-full overflow-hidden md:me-4">
                            <img class="w-full h-full object-cover"
                                src="{{ auth()->user()->picture_url ?? asset('images/person.png') }}" alt="">
                        </div>
                        <p class="text-sm font-bold text-slate-800 max-w-xs overflow-hidden line-clamp-1">
                            {{ auth()->user()->name }}</p>
                    </a>
                    <a @click="open = true" class="block md:hidden">
                        <div class="w-8 h-8 rounded-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                src="{{ auth()->user()->picture_url ?? asset('images/person.png') }}" alt="">
                        </div>
                    </a>
                    <x-backdrop x-show="open"></x-backdrop>
                    <div x-cloak x-show="open" @click.outside="open = false"
                        class="z-50 fixed top-0 right-0 w-3/4 h-screen bg-white px-6 pt-4"
                        x-transition:enter="transition liner duration-200"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition liner duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 translate-x-full">
                        <div class="w-full flex justify-end">
                            <a @click="open = false" class="block md:hidden">
                                <div class="w-8 h-8 rounded-full overflow-hidden">
                                    <img class="w-full h-full object-cover"
                                        src="{{ auth()->user()->picture_url ?? asset('images/person.png') }}"
                                        alt="">
                                </div>
                            </a>
                        </div>
                        <ul class="mt-6 border-b pb-3 mb-6">
                            @foreach ($navigation as $nav)
                                <li class="mb-3">
                                    <a href="{{ $nav['url'] }}" class="w-full flex items-center py-1">
                                        {!! $nav['icon'] !!}
                                        <span
                                            class="font-semibold {{ $nav['active'] ? 'text-purple-800' : '' }}">{{ $nav['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                            @if (auth()->user()->admin)
                                @foreach ($adminNavigation as $nav)
                                    <li class="mb-3">
                                        <a href="{{ $nav['url'] }}" class="w-full flex items-center py-1">
                                            {!! $nav['icon'] !!}
                                            <span
                                                class="font-semibold {{ $nav['active'] ? 'text-purple-800' : '' }}">{{ $nav['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <ul>
                            <li class="mb-3">
                                <a href="{{ route('profile') }}" class="w-full flex items-center">
                                    <span
                                        class="font-semibold {{ Route::currentRouteName() === 'profile' ? 'text-purple-800' : '' }}">プロフィールの編集</span>
                                </a>
                            </li>
                            @foreach ($subNavigation as $nav)
                                <li class="mb-3">
                                    <a href="{{ $nav['url'] }}" class="w-full flex items-center py-1">
                                        <span
                                            class="font-semibold {{ $nav['active'] ? 'text-purple-800' : '' }}">{{ $nav['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
            </header>
            <main class="relative px-3 md:px-10 pt-20 md:pt-6 pb-6">
                @if (count($message) !== 0)
                    <div class="mb-6">
                        @foreach ($message as $m)
                            <x-alert status="{{ $m['status'] }}" title="{{ $m['title'] }}"
                                message="{!! $m['message'] !!}">
                            </x-alert>
                        @endforeach
                    </div>
                @endif
                @if (session('message'))
                    <x-notification status="success">{{ session('message') }}</x-notification>
                @endif
                {{ $slot }}
            </main>
        </section>
    </div>
    @livewireScripts
</body>

</html>
