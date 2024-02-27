<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    @vite('resources/ts/admin.ts')
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    <title>{{ config('app.name') }} | 管理画面</title>
    @livewireStyles
</head>

<body class="min-h-screen text-app-color bg-slate-100">
    <header class="fixed top-0 left-0 w-full h-20 md:mb-0 px-6 md:px-10 z-40 duration-200">
        <nav class="h-full flex justify-between items-center">
            <x-logo class="h-12 py-3"></x-logo>
        </nav>
    </header>
    <main class="mt-20">
        {{ $slot }}
    </main>
    @livewireScripts
</body>

</html>
