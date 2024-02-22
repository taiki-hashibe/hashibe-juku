<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    @vite('resources/ts/admin.ts')
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    <title>{{ config('app.name') }} | 管理画面</title>
    @livewireStyles
</head>

<body class="min-h-screen text-app-color">
    <h1 class="hidden">{{ config('app.name') }}</h1>
    <div class="flex w-full min-h-screen">
        <nav class="sticky top-0 hidden md:block md:w-64 px-3 pb-4 md:pt-3 border-e h-screen bg-slate-900">
            <div class="flex flex-col justify-between w-full h-full">
                <div>
                    <div class="mb-4 ps-4 py-8">
                        <a class="text-white" href="{{ route('admin.dashboard') }}" aria-label="ダッシュボード">
                            <x-logo class="h-12 py-3" valiant="dark"></x-logo>
                        </a>
                    </div>
                    <ul>
                        @foreach ($navigation as $nav)
                            <li class="mb-3">
                                <a href="{{ $nav['url'] }}"
                                    class="w-full px-4 py-2 flex items-center rounded-md duration-100 hover:bg-white/25">
                                    {!! $nav['icon'] !!}
                                    <span
                                        class="font-semibold text-nowrap text-sm {{ $nav['active'] ? 'text-white' : 'text-slate-400' }}">{{ $nav['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
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
                                        class="font-semibold text-nowrap text-sm {{ $nav['active'] ? 'text-purple-800' : '' }}">{{ $nav['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
        <section class="w-full">
            <header
                class="fixed bg-slate-900 md:bg-transparent top-0 z-40 md:z-auto md:static md:top-auto w-full border-b mb-4 md:mb-0 md:border-0 px-6 md:px-10 py-4 md:py-6">
                <nav x-data="{ open: false }" class="flex justify-between items-center md:justify-end">
                    <a href="{{ route('admin.dashboard') }}" class="text-white md:hidden md:text-app-color">
                        <x-logo class="h-12 py-3" valiant="dark"></x-logo>
                    </a>
                    <span class="hidden md:flex items-center">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = true" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-700 me-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-sm">{{ auth()->user()->name ?? auth()->user()->user_id }}</p>
                            </button>
                            <div x-cloak x-ref="panel" x-show="open" @click.outside="open = false"
                                class="absolute top-full left-0 sm:left-auto sm:right-0 z-10 mt-2 w-56 origin-top-left sm:origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                x-transition:enter="transition liner duration-200"
                                x-transition:enter-start="opacity-0 scale-0"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition liner duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-0">
                                <div class="px-1 py-2" role="none">
                                    <form action="{{ route('admin.logout') }}" method="post">
                                        @csrf
                                        <button
                                            class="w-full px-4 py-2 flex items-start rounded-md duration-100 hover:bg-slate-100">
                                            ログアウト
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </span>
                    <a @click="open = true" class="block md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-slate-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <x-backdrop x-show="open"></x-backdrop>
                    <div x-cloak x-show="open" @click.outside="open = false"
                        class="z-50 fixed top-0 right-0 w-3/4 h-screen bg-slate-900 px-6 pt-4"
                        x-transition:enter="transition liner duration-200"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition liner duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 translate-x-full">
                        <div class="w-full flex justify-end">
                            <a @click="open = false" class="block md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </div>
                        <ul class="mt-6 pb-3 mb-6">
                            @foreach ($navigation as $nav)
                                <li class="mb-3">
                                    <a href="{{ $nav['url'] }}"
                                        class="w-full flex items-center py-1 hover:bg-white/25">
                                        {!! $nav['icon'] !!}
                                        <span
                                            class="font-semibold {{ $nav['active'] ? 'text-white' : 'text-slate-300' }}">{{ $nav['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <ul>
                            @foreach ($subNavigation as $nav)
                                <li class="mb-3">
                                    <a href="{{ $nav['url'] }}" class="w-full flex items-center py-1">
                                        <span
                                            class="font-semibold {{ $nav['active'] ? 'text-purple-800' : '' }}">{{ $nav['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                            <li class="mb-3">
                                <form action="{{ route('admin.logout') }}" method="post">
                                    @csrf
                                    <button class="w-full flex items-center py-1 hover:bg-white/25">
                                        <span class="font-semibold text-slate-300">
                                            ログアウト
                                        </span>
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </div>
                </nav>
            </header>
            <main class="relative px-3 md:px-10 pt-20 md:pt-6 pb-6">
                @if (session('message'))
                    <x-alert status="success" title="{{ session('message') }}" class="mb-6"></x-alert>
                @endif
                {{ $slot }}
            </main>
        </section>
    </div>
    @livewireScripts
</body>

</html>
