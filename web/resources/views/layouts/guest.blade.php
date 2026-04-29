<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'E-ticket'))</title>
    @stack('head')
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            @yield('body-style')
        }
    </style>
    @stack('styles')
</head>

<body class="@yield('body-class')">
    @yield('content')
    @stack('scripts')
</body>

</html>
