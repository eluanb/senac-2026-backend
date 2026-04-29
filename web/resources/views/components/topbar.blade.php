<style>
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
        width: 220px;
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
        font-size: 15px;
        color: var(--text-muted);
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
        flex-shrink: 0;
    }

    @media (max-width: 900px) {
        .topbar {
            padding: 0 16px;
        }

        .search-box {
            width: 160px;
        }
    }
</style>

<header class="topbar">
    <span class="topbar-title">@yield('page-title', 'Painel')</span>
    <div class="topbar-sep"></div>
    <div class="search-box">
        <span style="color:var(--text-muted);font-size:13px">🔍</span>
        <input type="text" placeholder="Buscar...">
    </div>
    <div class="topbar-icon">🔔</div>
    <div class="avatar">JD</div>
</header>
