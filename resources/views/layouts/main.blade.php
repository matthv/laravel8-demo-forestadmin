<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Welcome">
    <link rel="icon" type="image/png" href="https://laravel.com/img/favicon/favicon-16x16.png" />
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }}">
    <meta property="og:description" content="Welcome">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://i.imgur.com/inBDvbX.png">
    <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="content">
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('javascript')
</body>
</html>
