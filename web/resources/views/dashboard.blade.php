@extends('layouts.app')

@section('title', 'Dashboard | E-ticket')
@section('page-title', 'Dashboard')

@push('styles')
<link href="{{ asset('css/pages/dashboard.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="congrats-card">
    <div>
        <div class="congrats-title">Parabens, Joao!</div>
        <div class="congrats-sub">Voce atingiu a meta do mes. Confira suas vendas abaixo.</div>
        <button class="btn-primary">Ver Relatorio</button>
    </div>
    <div style="margin-left:auto;text-align:right">
        <div class="congrats-amount">$89k</div>
        <div style="font-size:12px;color:#8cb4e0">Receita total</div>
    </div>
    <div class="congrats-trophy">🏆</div>
</div>

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:rgba(79,142,247,.12)">📦</div>
        <div class="stat-label">Novos Pedidos</div>
        <div class="stat-value">1.2k</div>
        <div class="stat-change up">▲ 12.4% este mes</div>
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

<div class="mid-row">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Resumo de Pedidos</div>
                <div class="card-subtitle">Jan - Dez 2024</div>
            </div>
            <div class="tabs">
                <div class="tab active">Mes</div>
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
            <path d="M0 120 C40 100,80 60,120 80 C160 100,200 40,240 50 C280 60,320 30,360 45 C400 60,440 80,480 55 L480 160 L0 160Z" fill="url(#g1)" />
            <path d="M0 120 C40 100,80 60,120 80 C160 100,200 40,240 50 C280 60,320 30,360 45 C400 60,440 80,480 55" fill="none" stroke="#4f8ef7" stroke-width="2.5" stroke-linejoin="round" />
            <path d="M0 140 C40 130,80 100,120 110 C160 120,200 90,240 100 C280 110,320 80,360 95 C400 110,440 130,480 105 L480 160 L0 160Z" fill="url(#g2)" />
            <path d="M0 140 C40 130,80 100,120 110 C160 120,200 90,240 100 C280 110,320 80,360 95 C400 110,440 130,480 105" fill="none" stroke="#a78bfa" stroke-width="2" stroke-linejoin="round" stroke-dasharray="4 2" />
        </svg>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Crescimento de Receita</div>
                <div class="card-subtitle">$23,680 este mes</div>
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
                    <circle cx="45" cy="45" r="34" fill="none" stroke="#4f8ef7" stroke-width="10" stroke-dasharray="90 123" stroke-linecap="round" transform="rotate(-90 45 45)" />
                    <circle cx="45" cy="45" r="34" fill="none" stroke="#a78bfa" stroke-width="10" stroke-dasharray="50 163" stroke-dashoffset="-90" stroke-linecap="round" transform="rotate(-90 45 45)" />
                    <circle cx="45" cy="45" r="34" fill="none" stroke="#22d3a5" stroke-width="10" stroke-dasharray="33 180" stroke-dashoffset="-140" stroke-linecap="round" transform="rotate(-90 45 45)" />
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

<div class="bot-row">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Campanhas de Marketing</div>
                <div class="card-subtitle">5,352 ativos este mes</div>
            </div>
            <button class="btn-primary" style="font-size:12px;padding:6px 14px">Ver Mais</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Campanha</th>
                    <th>Crescimento</th>
                    <th>Cobrancas</th>
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
                        <span class="status-badge {{ $c[3] }}">{{ ucfirst($c[3]) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.tab').forEach((tab) => {
        tab.addEventListener('click', function() {
            this.closest('.tabs').querySelectorAll('.tab').forEach((t) => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush
