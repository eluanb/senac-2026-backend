@extends('layouts.app')

@section('title', 'Chamados | E-ticket')
@section('page-title', 'Chamados')

@push('styles')
<link href="{{ asset('css/pages/ticket.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:rgba(79,142,247,.12)">🎫</div>
        <div class="stat-label">Total de Chamados</div>
        <div class="stat-value">{{ $chamados->count() }}</div>
        <div class="stat-change up">▲ atualizacao em tempo real</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:rgba(251,191,36,.12)">🔓</div>
        <div class="stat-label">Em Aberto</div>
        <div class="stat-value" style="color:var(--accent)">{{ $chamados->where('status', 'Aberto')->count() + $chamados->where('status', 'open')->count() }}</div>
        <div class="stat-change warn">● fila ativa</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:rgba(34,211,165,.12)">✅</div>
        <div class="stat-label">Resolvidos</div>
        <div class="stat-value" style="color:var(--success)">{{ $chamados->whereIn('status', ['Resolvido', 'closed', 'done'])->count() }}</div>
        <div class="stat-change up">▲ produtividade da equipe</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:rgba(167,139,250,.12)">⏱️</div>
        <div class="stat-label">Pendentes</div>
        <div class="stat-value">{{ $chamados->whereIn('status', ['Pendente', 'pending'])->count() }}</div>
        <div class="stat-change down">▼ precisa de atencao</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Lista de Chamados</div>
            <div class="card-subtitle">Mostrando <span id="rowCount">0</span> de {{ $chamados->count() }} registros</div>
        </div>
        <div class="filters">
            <select class="filter-select" id="statusFilter">
                <option value="">Todos os status</option>
                <option value="aberto">Aberto</option>
                <option value="pendente">Pendente</option>
                <option value="resolvido">Resolvido</option>
                <option value="cancelado">Cancelado</option>
            </select>
            <input type="text" id="searchInput" class="search-input" placeholder="Buscar chamado...">
            <button class="btn-primary" type="button" onclick="document.getElementById('modalNovoChamado').classList.add('open')">+ Novo Chamado</button>
        </div>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Descricao</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($chamados as $chamado)
                @php
                    $status = strtolower(trim((string) $chamado->status));
                    $statusClass = in_array($status, ['aberto', 'open'], true) ? 'aberto' :
                        (in_array($status, ['resolvido', 'closed', 'done'], true) ? 'resolvido' :
                        (in_array($status, ['pendente', 'pending'], true) ? 'pendente' : 'cancelado'));
                @endphp
                <tr data-status="{{ $statusClass }}" data-search="{{ strtolower($chamado->title . ' ' . $chamado->description . ' #' . $chamado->id) }}">
                    <td>#{{ $chamado->id }}</td>
                    <td>{{ $chamado->title }}</td>
                    <td>{{ $chamado->description }}</td>
                    <td><span class="badge {{ $statusClass }}">{{ ucfirst($chamado->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="color:var(--text-muted)">Nenhum chamado encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:flex;align-items:center">
        <div class="pagination" id="pagination"></div>
        <div class="page-info" id="pageInfo"></div>
    </div>
</div>
@endsection

@push('modals')
<div class="modal-backdrop" id="modalNovoChamado" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Novo Chamado</span>
            <button class="modal-close" type="button" onclick="document.getElementById('modalNovoChamado').classList.remove('open')">✕</button>
        </div>

        @if ($errors->any())
        <div class="modal-alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="modal-alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf
            <div class="modal-field">
                <label class="modal-label">Título</label>
                <input type="text" name="title" class="modal-input" placeholder="Descreva o problema brevemente" value="{{ old('title') }}" required>
            </div>
            <div class="modal-field">
                <label class="modal-label">Descrição</label>
                <textarea name="description" class="modal-textarea" rows="4" placeholder="Detalhe o chamado..." required>{{ old('description') }}</textarea>
            </div>
            <div class="modal-field">
                <label class="modal-label">Status</label>
                <select name="status" class="modal-select">
                    <option value="Aberto" {{ old('status') === 'Aberto' ? 'selected' : '' }}>Aberto</option>
                    <option value="Pendente" {{ old('status') === 'Pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="Resolvido" {{ old('status') === 'Resolvido' ? 'selected' : '' }}>Resolvido</option>
                    <option value="Cancelado" {{ old('status') === 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="modal-btn-cancel" onclick="document.getElementById('modalNovoChamado').classList.remove('open')">Cancelar</button>
                <button type="submit" class="modal-btn-submit">Criar Chamado</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    @if ($errors->any())
    document.getElementById('modalNovoChamado').classList.add('open');
    @endif

    (function() {
        const rowsPerPage = 8;
        const tableBody = document.getElementById('tableBody');
        const rows = Array.from(tableBody.querySelectorAll('tr[data-status]'));
        const statusFilter = document.getElementById('statusFilter');
        const searchInput = document.getElementById('searchInput');
        const pagination = document.getElementById('pagination');
        const rowCount = document.getElementById('rowCount');
        const pageInfo = document.getElementById('pageInfo');

        let currentPage = 1;

        function getFilteredRows() {
            const status = statusFilter.value.trim().toLowerCase();
            const search = searchInput.value.trim().toLowerCase();

            return rows.filter((row) => {
                const rowStatus = row.dataset.status || '';
                const rowSearch = row.dataset.search || '';
                const matchesStatus = !status || rowStatus === status;
                const matchesSearch = !search || rowSearch.includes(search);
                return matchesStatus && matchesSearch;
            });
        }

        function renderPagination(totalPages) {
            pagination.innerHTML = '';

            if (totalPages <= 1) {
                return;
            }

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
                btn.textContent = i;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    renderTable();
                });
                pagination.appendChild(btn);
            }
        }

        function renderTable() {
            const filtered = getFilteredRows();
            const totalPages = Math.max(1, Math.ceil(filtered.length / rowsPerPage));
            currentPage = Math.min(currentPage, totalPages);

            rows.forEach((row) => {
                row.style.display = 'none';
            });

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            filtered.slice(start, end).forEach((row) => {
                row.style.display = '';
            });

            rowCount.textContent = filtered.length;
            pageInfo.textContent = filtered.length ? `Pagina ${currentPage} de ${totalPages}` : 'Sem resultados';
            renderPagination(totalPages);
        }

        statusFilter.addEventListener('change', () => {
            currentPage = 1;
            renderTable();
        });

        searchInput.addEventListener('input', () => {
            currentPage = 1;
            renderTable();
        });

        renderTable();
    })();
</script>
@endpush
