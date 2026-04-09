<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0
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
        font-size: 14px
    }

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
        scrollbar-width: none
    }

    .sidebar::-webkit-scrollbar {
        display: none
    }

    .sidebar-logo {
        padding: 22px 20px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid var(--border)
    }

    .logo-icon {
        width: 34px;
        height: 34px;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px
    }

    .logo-text {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: -0.5px;
        color: var(--text-primary)
    }

    .sidebar-section {
        padding: 18px 14px 6px
    }

    .sidebar-section-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        color: var(--text-muted);
        padding: 0 8px;
        margin-bottom: 6px
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
        margin-bottom: 2px
    }

    .nav-item:hover {
        background: rgba(79, 142, 247, .08);
        color: var(--text-primary)
    }

    .nav-item.active {
        background: rgba(79, 142, 247, .15);
        color: var(--accent)
    }

    .nav-icon {
        font-size: 16px;
        width: 20px;
        text-align: center;
        flex-shrink: 0
    }

    .nav-badge {
        margin-left: auto;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 20px;
        background: rgba(79, 142, 247, .2);
        color: var(--accent)
    }

    .nav-arrow {
        margin-left: auto;
        font-size: 11px;
        transition: transform .2s
    }

    .nav-sub {
        padding-left: 34px;
        overflow: hidden;
        max-height: 0;
        transition: max-height .3s ease
    }

    .nav-item.open+.nav-sub {
        max-height: 200px
    }

    .nav-sub .nav-item {
        font-size: 13px;
        padding: 7px 10px
    }

    .main {
        margin-left: var(--sidebar-w);
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh
    }

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
        z-index: 50
    }

    .topbar-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        font-size: 16px
    }

    .topbar-sep {
        flex: 1
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 7px 14px;
        width: 200px
    }

    .search-box input {
        background: none;
        border: none;
        outline: none;
        color: var(--text-primary);
        font-size: 13px;
        width: 100%;
        font-family: inherit
    }

    .search-box input::placeholder {
        color: var(--text-muted)
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
        position: relative
    }

    .topbar-icon:hover {
        color: var(--text-primary);
        background: var(--bg-card2)
    }

    .notif-dot {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--danger);
        border: 2px solid var(--bg-sidebar)
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
        flex-shrink: 0
    }

    .lang-selector {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--text-muted);
        cursor: pointer
    }

    .content {
        padding: 28px;
        flex: 1
    }

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 22px
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px 22px;
        position: relative;
        overflow: hidden;
        transition: transform .2s
    }

    .stat-card:hover {
        transform: translateY(-2px)
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
        transition: opacity .2s
    }

    .stat-card:hover::before {
        opacity: 1
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 8px
    }

    .stat-value {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 6px
    }

    .stat-change {
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px
    }

    .stat-change.up {
        color: var(--success)
    }

    .stat-change.down {
        color: var(--danger)
    }

    .stat-change.warn {
        color: var(--warning)
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
        font-size: 18px
    }

    /* Table card */
    .card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 22px
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px
    }

    .card-title {
        font-weight: 600;
        font-size: 14px
    }

    .card-subtitle {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px
    }

    .filters {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap
    }

    .filter-select {
        background: var(--bg-card2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text-primary);
        font-size: 12px;
        padding: 5px 10px;
        outline: none;
        cursor: pointer
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 18px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--accent), #2563eb);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: opacity .2s
    }

    .btn-primary:hover {
        opacity: .88
    }

    .tbl-wrap {
        overflow-x: auto
    }

    table {
        width: 100%;
        border-collapse: collapse
    }

    thead th {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .6px;
        text-transform: uppercase;
        color: var(--text-muted);
        padding: 0 10px 12px 0;
        text-align: left;
        white-space: nowrap
    }

    tbody tr {
        border-top: 1px solid var(--border);
        cursor: pointer;
        transition: background .15s
    }

    tbody tr:hover {
        background: rgba(79, 142, 247, .04)
    }

    tbody td {
        padding: 11px 10px 11px 0;
        font-size: 13px;
        vertical-align: middle
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap
    }

    .badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0
    }

    .badge.aberto {
        background: rgba(79, 142, 247, .15);
        color: #78aeff
    }

    .badge.aberto::before {
        background: #4f8ef7
    }

    .badge.resolvido {
        background: rgba(34, 211, 165, .15);
        color: #22d3a5
    }

    .badge.resolvido::before {
        background: #22d3a5
    }

    .badge.pendente {
        background: rgba(251, 191, 36, .15);
        color: #fbbf24
    }

    .badge.pendente::before {
        background: #fbbf24
    }

    .badge.cancelado {
        background: rgba(248, 113, 113, .15);
        color: #f87171
    }

    .badge.cancelado::before {
        background: #f87171
    }

    .prio {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 600
    }

    .prio.alta {
        color: #f87171
    }

    .prio.media {
        color: #fbbf24
    }

    .prio.baixa {
        color: #22d3a5
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 8px
    }

    .user-av {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        flex-shrink: 0
    }

    .progress-bar {
        height: 4px;
        background: var(--bg-card2);
        border-radius: 2px;
        overflow: hidden;
        width: 56px
    }

    .progress-fill {
        height: 100%;
        border-radius: 2px
    }

    .sla-ok {
        background: var(--success)
    }

    .sla-warn {
        background: var(--warning)
    }

    .sla-late {
        background: var(--danger)
    }

    .tag {
        display: inline-block;
        background: var(--bg-card2);
        border: 1px solid var(--border);
        border-radius: 5px;
        padding: 2px 7px;
        font-size: 10px;
        color: var(--text-muted);
        margin-right: 3px
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 16px
    }

    .page-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-card2);
        border: 1px solid var(--border);
        color: var(--text-muted);
        font-size: 12px;
        cursor: pointer;
        transition: all .2s
    }

    .page-btn:hover,
    .page-btn.active {
        background: rgba(79, 142, 247, .2);
        color: var(--accent);
        border-color: rgba(79, 142, 247, .3)
    }

    .page-info {
        font-size: 11px;
        color: var(--text-muted);
        margin-left: auto
    }

    ::-webkit-scrollbar {
        width: 4px
    }

    ::-webkit-scrollbar-track {
        background: transparent
    }

    ::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 4px
    }
</style>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">⚡</div>
        <span class="logo-text">e-ticket</span>
    </div>
    <div class="sidebar-section">
        <div class="sidebar-section-label">Navegação</div>
        <a href="#" class="nav-item"><span class="nav-icon">🏠</span> Dashboard</a>
        <div class="nav-item open" id="navChamados">
            <span class="nav-icon">🎫</span> Chamados <span class="nav-arrow">›</span>
        </div>
        <div class="nav-sub" style="max-height:200px">
            <a href="#" class="nav-item active">Chamados</a>
            <a href="#" class="nav-item">Categorias</a>
        </div>
    </div>
</aside>

<div class="main">

    <header class="topbar">
        <span class="topbar-title">Dashboard</span>
        <div class="topbar-sep"></div>
        <div class="search-box">
            <span style="color:var(--text-muted);font-size:13px">🔍</span>
            <input type="text" placeholder="Buscar...">
        </div>
        <span class="lang-selector">🇧🇷 PT ▾</span>
        <div class="topbar-icon">🌙</div>
        <div class="topbar-icon">🔔<span class="notif-dot"></span></div>
        <div class="topbar-icon">⚙️</div>
        <div class="avatar">JD</div>
    </header>

    <div class="content">

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(79,142,247,.12)">🎫</div>
                <div class="stat-label">Total de Chamados</div>
                <div class="stat-value">1.847</div>
                <div class="stat-change up">▲ 12.4% este mês</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(251,191,36,.12)">🔓</div>
                <div class="stat-label">Em Aberto</div>
                <div class="stat-value" style="color:var(--accent)">342</div>
                <div class="stat-change warn">● 18.5% do total</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(34,211,165,.12)">✅</div>
                <div class="stat-label">Resolvidos Hoje</div>
                <div class="stat-value" style="color:var(--success)">58</div>
                <div class="stat-change up">▲ 6.3% vs ontem</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(167,139,250,.12)">⏱️</div>
                <div class="stat-label">Tempo Médio</div>
                <div class="stat-value">4h 32m</div>
                <div class="stat-change down">▼ 8.1% mais rápido</div>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Lista de Chamados</div>
                    <div class="card-subtitle">Mostrando <span id="rowCount">10</span> de 1.847 registros</div>
                </div>
                <div class="filters">
                    <select class="filter-select" id="statusFilter" onchange="filterTable()">
                        <option value="">Todos os status</option>
                        <option value="Aberto">Aberto</option>
                        <option value="Pendente">Pendente</option>
                        <option value="Resolvido">Resolvido</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                    <select class="filter-select" id="prioFilter" onchange="filterTable()">
                        <option value="">Todas as prioridades</option>
                        <option value="Alta">Alta</option>
                        <option value="Média">Média</option>
                        <option value="Baixa">Baixa</option>
                    </select>
                    <input type="text" id="searchInput" placeholder="🔍 Buscar chamado..." oninput="filterTable()" style="background:var(--bg-card2);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);font-size:12px;padding:5px 12px;outline:none;width:170px">
                    <button class="btn-primary">＋ Novo Chamado</button>
                </div>
            </div>
            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:24px"><input type="checkbox" style="accent-color:var(--accent)"></th>
                            <th>ID</th>
                            <th>Titulo</th>
                            <th>Descrição</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach($chamados as $chamado)
                        <tr>
                            <td><input type="checkbox" style="accent-color:var(--accent)"></td>
                            <td>#{{ $chamado->id }}</td>
                            <td>{{ $chamado->title }}</td>
                            <td>{{ $chamado->description }}</td>
                            <td><span class="badge {{ strtolower($chamado->status) }}">{{ $chamado->status }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display:flex;align-items:center">
                <div class="pagination" id="pagination"></div>
                <div class="page-info" id="pageInfo"></div>
            </div>
        </div>

    </div>
</div>