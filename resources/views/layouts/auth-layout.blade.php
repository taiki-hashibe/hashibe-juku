<!DOCTYPE html>
<html lang="ja">

<head>
    @if (isset($noindex))
        <meta name="robots" content="noindex">
    @endif

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
    @else
        <meta name="robots" content="noindex">
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    {!! SEO::generate() !!}
    @vite('resources/ts/app.ts')
    @livewireStyles
</head>

<body {{ $attributes->merge([
    'class' => 'min-h-screen text-color bg-slate-100',
]) }}>
    <header class="fixed top-0 left-0 w-full h-20 md:mb-0 px-6 md:px-10 z-40 duration-200 {{ $headerClass ?? '' }}">
        <nav class="h-full flex justify-between items-center">
            <h1 class="hidden">{{ config('app.name') }}</h1>
            @if (isset($unlink) && $unlink)
                <div>
                    <x-logo class="md:ps-4 h-12 py-3"></x-logo>
                </div>
            @else
                <a href="{{ route('user.home') }}" aria-label="トップページ">
                    <x-logo class="md:ps-4 h-12 py-3"></x-logo>
                </a>
            @endif
            <div x-data="{ open: false }" class="relative">
                <button @click="open = true" class="flex items-center hover:underline">
                    @if ($user->subscribed('online-salon'))
                        <x-gradation-container-empty class="me-2 rounded-full" innerClass="rounded-full">
                            @if ($user->picture_url)
                                <img class="w-8 h-8 rounded-full" src="{{ $user->picture_url }}" alt="">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-8 h-8 text-slate-700 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            @endif
                        </x-gradation-container-empty>
                    @else
                        <div class="me-2">
                            @if ($user->picture_url)
                                <img class="w-8 h-8 rounded-full" src="{{ $user->picture_url }}" alt="">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-8 h-8 text-slate-700 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            @endif
                        </div>
                    @endif
                    <p class="text-sm relative">
                        {{ $user->name }}
                    </p>
                </button>
                <menu x-cloak x-ref="panel" x-show="open" @click.outside="open = false"
                    class="absolute top-full left-auto right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white dark:bg-slate-700 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                    x-transition:enter="transition liner duration-200" x-transition:enter-start="opacity-0 scale-0"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition liner duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-0">
                    <li class="px-1 py-2">
                        <a href="{{ route('user.bookmark') }}"
                            class="w-full px-4 py-2 flex items-start rounded-md duration-100 hover:bg-slate-100 dark:hover:bg-slate-600">
                            <span class="relative">ブックマーク</span></a>
                    </li>
                    <li class="px-1 py-2">
                        <a href="{{ route('user.complete') }}"
                            class="w-full px-4 py-2 flex items-start rounded-md duration-100 hover:bg-slate-100 dark:hover:bg-slate-600">
                            <span class="relative">完了したレッスン</span></a>
                    </li>
                    <li class="px-1 py-2" role="none">
                        <form action="{{ route('user.logout') }}" method="post">
                            @csrf
                            <button
                                class="w-full px-4 py-2 flex items-start rounded-md duration-100 hover:bg-slate-100 dark:hover:bg-slate-600">
                                ログアウト
                            </button>
                        </form>
                    </li>
                </menu>
            </div>
        </nav>
    </header>
    <main class="mt-20">
        <x-container>
            @if (session('message'))
                <x-alert status="success" title="{{ session('message') }}" class="mb-6"></x-alert>
            @endif
            @if (isset($errors) && $errors->any())
                <x-alert status="danger" title="エラーが発生しました" class="mb-6"></x-alert>
                @foreach ($errors->all() as $error)
                    <p class="text-rose-600">{{ $error }}</p>
                @endforeach
            @endif
            {{ $slot }}
        </x-container>
    </main>
    <x-footer />
    @livewireScripts
</body>

</html>
