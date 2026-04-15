<style>
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
        margin-right: 8px;
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.3);
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
        text-decoration: none;
        color: inherit;
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
        color: var(--text-muted);
        font-weight: 500;
        font-size: 13.5px;
        transition: all .2s;
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

    .nav-icon {
        font-size: 16px;
        width: 20px;
        text-align: center;
        flex-shrink: 0;
    }

    .logout-link {
        margin-top: auto;
        margin: auto 14px 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 9px 12px;
        text-decoration: none;
        color: var(--text-muted);
        transition: .2s;
    }

    .logout-link:hover {
        color: var(--danger);
        border-color: rgba(248, 113, 113, .35);
        background: rgba(248, 113, 113, .08);
    }
</style>

<aside class="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <div class="logo-icon">⚡</div>
        <span class="logo-text">e-ticket</span>
    </a>

    <div class="sidebar-section">
        <div class="sidebar-section-label">Navegacao</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">🏠</span> Dashboard
        </a>
        <a href="{{ route('tickets.index') }}" class="nav-item {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
            <span class="nav-icon">🎫</span> Chamados
        </a>
    </div>

    <a href="{{ route('logout') }}" class="logout-link">
        ⎋ Sair
    </a>
</aside>
