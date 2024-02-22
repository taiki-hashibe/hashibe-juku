<?php App::setLocale(config('app.http_status_code_locale')); ?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <!-- Scripts -->
    @vite(['resources/ts/app.ts'])
</head>

<body>
    @include('layouts.header')
    <main class="py-4 container">
        <div class="mb-3">
            <h1 class="text-secondary mb-4 text-center">@yield('title')</h1>
            <p class="text-secondary text-center mb-2">只今サービスのメンテナンス中です</p>
        </div>
        {{-- <a class="d-block ce-anchor text-center" href="{{ route('matching') }}">サービストップへ戻る</a> --}}
    </main>
    @include('layouts.footer')
</body>

</html>
