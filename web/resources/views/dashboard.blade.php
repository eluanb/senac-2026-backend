<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frest – Dashboard</title>
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

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-logo {
            padding: 22px 20px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border);
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .logo-text {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--text-primary);
        }

        .sidebar-section {
            padding: 18px 14px 6px;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 8px;
            margin-bottom: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            cursor: pointer;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 13.5px;
            transition: all .2s;
            position: relative;
            text-decoration: none;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: rgba(79, 142, 247, .08);
            color: var(--text-primary);
        }

        .nav-item.active {
            background: rgba(79, 142, 247, .15);
            color: var(--accent);
        }

        .nav-item.active .nav-icon {
            color: var(--accent);
        }

        .nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            background: rgba(79, 142, 247, .2);
            color: var(--accent);
        }

        .nav-badge.green {
            background: rgba(34, 211, 165, .15);
            color: var(--success);
        }

        .nav-arrow {
            margin-left: auto;
            font-size: 11px;
            transition: transform .2s;
        }

        .nav-item.open .nav-arrow {
            transform: rotate(90deg);
        }

        .nav-sub {
            padding-left: 34px;
            overflow: hidden;
            max-height: 0;
            transition: max-height .3s ease;
        }

        .nav-item.open+.nav-sub {
            max-height: 200px;
        }

        .nav-sub .nav-item {
            font-size: 13px;
            padding: 7px 10px;
        }

        .nav-sub .nav-item.active::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--accent);
        }

        /* ─── MAIN ─── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            height: 64px;
            background: var(--bg-sidebar);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 600;
            font-size: 16px;
        }

        .topbar-sep {
            flex: 1;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 7px 14px;
            width: 200px;
        }

        .search-box input {
            background: none;
            border: none;
            outline: none;
            color: var(--text-primary);
            font-size: 13px;
            width: 100%;
            font-family: inherit;
        }

        .search-box input::placeholder {
            color: var(--text-muted);
        }

        .topbar-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 15px;
            color: var(--text-muted);
            transition: all .2s;
            position: relative;
        }

        .topbar-icon:hover {
            color: var(--text-primary);
            background: var(--bg-card2);
        }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--danger);
            border: 2px solid var(--bg-sidebar);
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .lang-selector {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
        }

        /* ─── CONTENT ─── */
        .content {
            padding: 28px;
            flex: 1;
        }

        /* ─── STAT CARDS ─── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
            transition: transform .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            opacity: 0;
            transition: opacity .2s;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 8px;
        }

        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .stat-change {
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-change.up {
            color: var(--success);
        }

        .stat-change.down {
            color: var(--danger);
        }

        .stat-icon-wrap {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        /* ─── MIDDLE ROW ─── */
        .mid-row {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 18px;
            margin-bottom: 22px;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .card-title {
            font-weight: 600;
            font-size: 14px;
        }

        .card-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .tabs {
            display: flex;
            gap: 4px;
            background: var(--bg-card2);
            padding: 4px;
            border-radius: 8px;
        }

        .tab {
            padding: 5px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            color: var(--text-muted);
            transition: all .2s;
        }

        .tab.active {
            background: var(--accent);
            color: #fff;
        }

        /* SVG Chart */
        .chart-area {
            width: 100%;
            height: 160px;
        }

        /* Revenue mini bars */
        .rev-bars {
            display: flex;
            align-items: flex-end;
            gap: 6px;
            height: 80px;
            margin-top: 12px;
        }

        .rev-bar {
            flex: 1;
            border-radius: 4px 4px 0 0;
            background: linear-gradient(180deg, var(--accent), rgba(79, 142, 247, .2));
            transition: opacity .2s;
        }

        .rev-bar:hover {
            opacity: .8;
        }

        .rev-bar.accent2 {
            background: linear-gradient(180deg, var(--accent2), rgba(167, 139, 250, .2));
        }

        /* Donut */
        .donut-wrap {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
        }

        .donut-legend {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ─── BOTTOM ROW ─── */
        .bot-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 0 12px;
            text-align: left;
        }

        tbody tr {
            border-top: 1px solid var(--border);
        }

        tbody td {
            padding: 12px 0;
            font-size: 13px;
            vertical-align: middle;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge.open {
            background: rgba(79, 142, 247, .15);
            color: var(--accent);
        }

        .status-badge.closed {
            background: rgba(34, 211, 165, .15);
            color: var(--success);
        }

        .status-badge.pending {
            background: rgba(251, 191, 36, .15);
            color: var(--warning);
        }

        /* Earnings list */
        .earn-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-top: 1px solid var(--border);
        }

        .earn-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .earn-name {
            font-size: 13px;
            font-weight: 500;
        }

        .earn-sub {
            font-size: 11px;
            color: var(--text-muted);
        }

        .earn-amt {
            margin-left: auto;
            font-weight: 700;
            font-size: 14px;
        }

        .earn-amt.up {
            color: var(--success);
        }

        .earn-amt.down {
            color: var(--danger);
        }

        /* Congratulations card */
        .congrats-card {
            background: linear-gradient(135deg, #1e3a5f 0%, #162d4a 100%);
            border: 1px solid rgba(79, 142, 247, .25);
            border-radius: var(--radius);
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 22px;
        }

        .congrats-trophy {
            font-size: 52px;
            line-height: 1;
        }

        .congrats-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .congrats-sub {
            font-size: 12px;
            color: #8cb4e0;
            margin-bottom: 14px;
        }

        .btn-primary {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--accent), #2563eb);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: opacity .2s;
        }

        .btn-primary:hover {
            opacity: .88;
        }

        .congrats-amount {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        /* Scrollbar */
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
    </style>
</head>

<body>

    {{-- ─── SIDEBAR ─── --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">⚡</div>
            <span class="logo-text">e-ticket</span>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-label">Navegação</div>
            <a href="#" class="nav-item active">
                <span class="nav-icon">🏠</span> Dashboard
            </a>
            <div class="nav-item open" onclick="this.classList.toggle('open'); this.nextElementSibling.style.maxHeight = this.classList.contains('open') ? '200px' : '0'">
                Chamados <span class="nav-arrow">›</span>
            </div>
            <div class="nav-sub" style="max-height:200px">
                <a href="#" class="nav-item">Chamados</a>
                <a href="#" class="nav-item">Categorias</a>
            </div>

        </div>

    </aside>

    {{-- ─── MAIN ─── --}}
    <div class="main">

        {{-- TOPBAR --}}
        <header class="topbar">
            <span class="topbar-title">Dashboard</span>
            <div class="topbar-sep"></div>

            <div class="search-box">
                <span style="color:var(--text-muted);font-size:13px">🔍</span>
                <input type="text" placeholder="Buscar...">
            </div>

            <span class="lang-selector">🇧🇷 PT ▾</span>

            <div class="topbar-icon">
                🌙
            </div>
            <div class="topbar-icon">
                🔔
                <span class="notif-dot"></span>
            </div>
            <div class="topbar-icon">⚙️</div>
            <div class="avatar">JD</div>
        </header>

        {{-- CONTENT --}}
        <div class="content">

            {{-- Congratulations Banner --}}
            <div class="congrats-card">
                <div>
                    <div class="congrats-title">Parabéns, João! 🎉</div>
                    <div class="congrats-sub">Você atingiu a meta do mês. Confira suas vendas abaixo.</div>
                    <button class="btn-primary">Ver Relatório</button>
                </div>
                <div style="margin-left:auto;text-align:right">
                    <div class="congrats-amount">$89k</div>
                    <div style="font-size:12px;color:#8cb4e0">Receita total</div>
                </div>
                <div class="congrats-trophy">🏆</div>
            </div>

            {{-- Stat Cards --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(79,142,247,.12)">📦</div>
                    <div class="stat-label">Novos Pedidos</div>
                    <div class="stat-value">1.2k</div>
                    <div class="stat-change up">▲ 12.4% este mês</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(34,211,165,.12)">👥</div>
                    <div class="stat-label">Visitantes</div>
                    <div class="stat-value">46.6k</div>
                    <div class="stat-change up">▲ 8.1% esta semana</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(251,191,36,.12)">💰</div>
                    <div class="stat-label">Receita Total</div>
                    <div class="stat-value">$23.4k</div>
                    <div class="stat-change down">▼ 2.3% vs anterior</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(167,139,250,.12)">📈</div>
                    <div class="stat-label">Crescimento</div>
                    <div class="stat-value">3,259</div>
                    <div class="stat-change up">▲ 5.0% hoje</div>
                </div>
            </div>

            {{-- Middle Row --}}
            <div class="mid-row">

                {{-- Order Summary Chart --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Resumo de Pedidos</div>
                            <div class="card-subtitle">Jan – Dez 2024</div>
                        </div>
                        <div class="tabs">
                            <div class="tab active">Mês</div>
                            <div class="tab">Ano</div>
                        </div>
                    </div>
                    <svg class="chart-area" viewBox="0 0 560 160" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="g1" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#4f8ef7" stop-opacity=".35" />
                                <stop offset="100%" stop-color="#4f8ef7" stop-opacity="0" />
                            </linearGradient>
                            <linearGradient id="g2" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#a78bfa" stop-opacity=".25" />
                                <stop offset="100%" stop-color="#a78bfa" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        {{-- Area 1 --}}
                        <path d="M0 120 C40 100,80 60,120 80 C160 100,200 40,240 50 C280 60,320 30,360 45 C400 60,440 80,480 55 L480 160 L0 160Z" fill="url(#g1)" />
                        <path d="M0 120 C40 100,80 60,120 80 C160 100,200 40,240 50 C280 60,320 30,360 45 C400 60,440 80,480 55" fill="none" stroke="#4f8ef7" stroke-width="2.5" stroke-linejoin="round" />
                        {{-- Area 2 --}}
                        <path d="M0 140 C40 130,80 100,120 110 C160 120,200 90,240 100 C280 110,320 80,360 95 C400 110,440 130,480 105 L480 160 L0 160Z" fill="url(#g2)" />
                        <path d="M0 140 C40 130,80 100,120 110 C160 120,200 90,240 100 C280 110,320 80,360 95 C400 110,440 130,480 105" fill="none" stroke="#a78bfa" stroke-width="2" stroke-linejoin="round" stroke-dasharray="4 2" />
                        {{-- Grid lines --}}
                        <line x1="0" y1="40" x2="560" y2="40" stroke="rgba(255,255,255,.04)" stroke-width="1" />
                        <line x1="0" y1="80" x2="560" y2="80" stroke="rgba(255,255,255,.04)" stroke-width="1" />
                        <line x1="0" y1="120" x2="560" y2="120" stroke="rgba(255,255,255,.04)" stroke-width="1" />
                    </svg>
                    <div style="display:flex;gap:18px;margin-top:10px">
                        <span style="font-size:12px;color:var(--accent);display:flex;align-items:center;gap:5px">
                            <span style="width:18px;height:3px;background:var(--accent);border-radius:2px;display:inline-block"></span>Pedidos
                        </span>
                        <span style="font-size:12px;color:var(--accent2);display:flex;align-items:center;gap:5px">
                            <span style="width:18px;height:2px;background:var(--accent2);border-radius:2px;display:inline-block;border-top:2px dashed var(--accent2)"></span>Retornos
                        </span>
                    </div>
                </div>

                {{-- Revenue Growth --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Crescimento de Receita</div>
                            <div class="card-subtitle">$23,680 este mês</div>
                        </div>
                    </div>
                    <div class="rev-bars">
                        @foreach([30,55,40,70,50,90,65,80,45,75,60,100] as $h)
                        <div class="rev-bar {{ $loop->index % 3 === 2 ? 'accent2' : '' }}" style="height:{{ $h }}%"></div>
                        @endforeach
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:6px">
                        @foreach(['J','F','M','A','M','J','J','A','S','O','N','D'] as $m)
                        <span style="font-size:10px;color:var(--text-muted);flex:1;text-align:center">{{ $m }}</span>
                        @endforeach
                    </div>

                    <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border)">
                        <div class="card-title" style="margin-bottom:12px">Visitas 2024</div>
                        <div class="donut-wrap">
                            <svg width="90" height="90" viewBox="0 0 90 90">
                                <circle cx="45" cy="45" r="34" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="10" />
                                <circle cx="45" cy="45" r="34" fill="none" stroke="#4f8ef7" stroke-width="10"
                                    stroke-dasharray="90 123" stroke-dashoffset="0" stroke-linecap="round" transform="rotate(-90 45 45)" />
                                <circle cx="45" cy="45" r="34" fill="none" stroke="#a78bfa" stroke-width="10"
                                    stroke-dasharray="50 163" stroke-dashoffset="-90" stroke-linecap="round" transform="rotate(-90 45 45)" />
                                <circle cx="45" cy="45" r="34" fill="none" stroke="#22d3a5" stroke-width="10"
                                    stroke-dasharray="33 180" stroke-dashoffset="-140" stroke-linecap="round" transform="rotate(-90 45 45)" />
                                <text x="45" y="49" text-anchor="middle" font-size="13" font-weight="700" fill="#e8edf5" font-family="Space Grotesk">43.6%</text>
                            </svg>
                            <div class="donut-legend">
                                <div class="legend-item"><span class="legend-dot" style="background:var(--accent)"></span>Amazon <b style="margin-left:auto">42%</b></div>
                                <div class="legend-item"><span class="legend-dot" style="background:var(--accent2)"></span>Etsy <b style="margin-left:auto">27%</b></div>
                                <div class="legend-item"><span class="legend-dot" style="background:var(--success)"></span>Direto <b style="margin-left:auto">25%</b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom Row --}}
            <div class="bot-row">

                {{-- Campaigns Table --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Campanhas de Marketing</div>
                            <div class="card-subtitle">5,352 ativos este mês</div>
                        </div>
                        <button class="btn-primary" style="font-size:12px;padding:6px 14px">Ver Mais</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Campanha</th>
                                <th>Crescimento</th>
                                <th>Cobranças</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $campaigns = [
                            ['Podcast Mailchimp', '+24.2%', '$11,468', 'open'],
                            ['Send a Newsletter', '+20.8%', '$2,543', 'closed'],
                            ['FB Ads Jordan', '-75.0%', '$22,819', 'pending'],
                            ['Shopify / Pio', '+5.5%', '$8,547', 'open'],
                            ];
                            @endphp
                            @foreach($campaigns as $c)
                            <tr>
                                <td>{{ $c[0] }}</td>
                                <td style="color:{{ str_starts_with($c[1], '+') ? '#22d3a5' : '#f87171' }};font-weight:600">{{ $c[1] }}</td>
                                <td>{{ $c[2] }}</td>
                                <td>
                                    <span class="status-badge {{ $c[3] }}">
                                        {{ ucfirst($c[3]) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Earnings --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Ganhos da Equipe</div>
                        <button class="btn-primary" style="font-size:12px;padding:6px 14px">+ Adicionar</button>
                    </div>
                    @php
                    $team = [
                    ['MR', '#4f8ef7', 'Miya Roberts', 'Designer Senior', '+$328', 'up'],
                    ['PL', '#a78bfa', 'Pittmana L.', 'Dev Frontend', '+$235', 'up'],
                    ['FA', '#22d3a5', 'Firanandes A.', 'Gerente de Vendas', '-$415', 'down'],
                    ['JS', '#fbbf24', 'Jhonson Smith', 'Dev Backend', '+$290', 'up'],
                    ];
                    @endphp
                    @foreach($team as $t)
                    <div class="earn-item">
                        <div class="earn-avatar" style="background:{{ $t[1] }}22;color:{{ $t[1] }}">{{ $t[0] }}</div>
                        <div>
                            <div class="earn-name">{{ $t[2] }}</div>
                            <div class="earn-sub">{{ $t[3] }}</div>
                        </div>
                        <div class="earn-amt {{ $t[5] }}">{{ $t[4] }}</div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>{{-- /content --}}
    </div>{{-- /main --}}

    <script>
        // Toggle nav sub-menus
        document.querySelectorAll('.nav-item .nav-arrow').forEach(arrow => {
            arrow.closest('.nav-item').addEventListener('click', function(e) {
                const sub = this.nextElementSibling;
                if (!sub || !sub.classList.contains('nav-sub')) return;
                this.classList.toggle('open');
                sub.style.maxHeight = this.classList.contains('open') ? '200px' : '0';
            });
        });

        // Tab switch
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                this.closest('.tabs').querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>