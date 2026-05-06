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
                    <th>Ações</th>
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
                    <td>
                        <div class="ticket-actions">
                            <a href="{{ route('tickets.chat', $chamado) }}" class="btn-chat">💬 Chat</a>

                            <button
                                type="button"
                                class="btn-ia"
                                onclick="abrirModalIA({{ $chamado->id }}, {{ json_encode($chamado->title) }}, {{ json_encode($chamado->description) }}, {{ json_encode($chamado->status) }})">🤖 IA</button>

                            @if ((auth()->user()->role ?? 'usuario') === 'atendente' && $chamado->assigned_to === null)
                            <form method="POST" action="{{ route('tickets.take', $chamado) }}">
                                @csrf
                                <button type="submit" class="btn-atender">🎧 Atender</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="color:var(--text-muted)">Nenhum chamado encontrado.</td>
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
{{-- Modal Sugestão IA --}}
<div class="modal-backdrop" id="modalIA" onclick="if(event.target===this)fecharModalIA()">
    <div class="modal modal-ia">
        <div class="modal-header">
            <span class="modal-title">🤖 Sugestão da IA</span>
            <button class="modal-close" type="button" onclick="fecharModalIA()">✕</button>
        </div>

        <div class="modal-ia-ticket">
            <div class="ia-ticket-row">
                <span class="ia-ticket-label">Título</span>
                <span class="ia-ticket-value" id="iaTitulo"></span>
            </div>
            <div class="ia-ticket-row">
                <span class="ia-ticket-label">Descrição</span>
                <span class="ia-ticket-value" id="iaDescricao"></span>
            </div>
            <div class="ia-ticket-row">
                <span class="ia-ticket-label">Status</span>
                <span class="ia-ticket-value" id="iaStatus"></span>
            </div>
        </div>

        <div class="modal-ia-body">
            <div id="iaEstado-idle">
                <p class="ia-hint">Clique em <strong>Consultar IA</strong> para obter uma sugestão de solução para este chamado.</p>
            </div>
            <div id="iaEstado-loading" style="display:none">
                <div class="ia-loading">
                    <span class="ia-spinner"></span>
                    <span>Analisando chamado...</span>
                </div>
            </div>
            <div id="iaEstado-result" style="display:none">
                <textarea class="ia-result-textarea" id="iaResultado" readonly style="display:block;box-sizing:border-box;width:100%;height:100%;min-height:380px;max-height:none;overflow-y:auto;resize:none;font-size:12px;line-height:1.45;"></textarea>
            </div>
            <div id="iaEstado-error" style="display:none">
                <div class="ia-error" id="iaErro"></div>
            </div>
        </div>

        <div class="modal-actions">
            <button type="button" class="modal-btn-cancel" onclick="fecharModalIA()">Fechar</button>
            <button type="button" class="modal-btn-ia" id="btnConsultarIA" onclick="consultarIA()">🤖 Consultar IA</button>
        </div>
    </div>
</div>

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
    @if($errors->any())
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

    // --- Modal IA ---
    let iaTicketId = null;

    function abrirModalIA(id, titulo, descricao, status) {
        iaTicketId = id;
        document.getElementById('iaTitulo').textContent = titulo;
        document.getElementById('iaDescricao').textContent = descricao;
        document.getElementById('iaStatus').textContent = status;
        document.getElementById('iaResultado').value = '';
        document.getElementById('iaErro').textContent = '';
        mostrarEstadoIA('idle');
        document.getElementById('btnConsultarIA').disabled = false;
        document.getElementById('modalIA').classList.add('open');
    }

    function fecharModalIA() {
        document.getElementById('modalIA').classList.remove('open');
        iaTicketId = null;
    }

    function mostrarEstadoIA(estado) {
        ['idle', 'loading', 'result', 'error'].forEach(e => {
            document.getElementById('iaEstado-' + e).style.display = e === estado ? '' : 'none';
        });
    }

    async function consultarIA() {
        if (!iaTicketId) return;
        const btn = document.getElementById('btnConsultarIA');
        btn.disabled = true;
        mostrarEstadoIA('loading');

        try {
            const res = await fetch(`/chamados/${iaTicketId}/sugestao-ia`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            const data = await res.json();

            if (!res.ok || data.error) {
                document.getElementById('iaErro').textContent = data.error || 'Erro ao consultar a IA.';
                mostrarEstadoIA('error');
            } else {
                document.getElementById('iaResultado').value = data.sugestao || '';
                mostrarEstadoIA('result');
            }
        } catch (e) {
            document.getElementById('iaErro').textContent = 'Falha na conexão. Tente novamente.';
            mostrarEstadoIA('error');
        } finally {
            btn.disabled = false;
        }
    }
</script>
@endpush