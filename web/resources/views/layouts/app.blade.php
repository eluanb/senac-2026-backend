<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel | E-ticket')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-body: #0d1117;
            --bg-sidebar: #111827;
            --bg-card: #1a2235;
            --bg-card2: #1e2a3a;
            --accent: #4f8ef7;
            --accent2: #a78bfa;
            --success: #22d3a5;
            --danger: #f87171;
            --warning: #fbbf24;
            --text-primary: #e8edf5;
            --text-muted: #6b7ea0;
            --border: rgba(255, 255, 255, 0.06);
            --sidebar-w: 240px;
            --radius: 14px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
        }

        .main {
            margin-left: calc(var(--sidebar-w) + 8px);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 8px;
            margin-bottom: 6px;
        }

        .content {
            padding: 28px;
            flex: 1;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        @media (max-width: 900px) {
            body {
                display: block;
            }

            .sidebar {
                position: static;
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }

            .main {
                margin-left: 0;
            }

            .content {
                padding: 18px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('components.sidebar')

    <div class="main">
        @include('components.topbar')

        <main class="content">
            @yield('content')
        </main>
    </div>

    @stack('modals')
    @stack('scripts')
</body>

</html>
