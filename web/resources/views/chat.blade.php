@extends('layouts.app')

@section('title', 'Chat – Ticket #' . $ticket->id . ' | E-ticket')
@section('page-title', 'Chat do Chamado')

@push('styles')
<style>
    .chat-wrap {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 120px);
        max-height: 820px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    /* ── Cabeçalho ─────────────────────────────────── */
    .chat-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        background: var(--bg-card2);
        border-bottom: 1px solid var(--border);
        flex-shrink: 0;
    }

    .chat-head-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .chat-head-title {
        font-weight: 700;
        font-size: 14px;
        color: var(--text-primary);
    }

    .chat-head-sub {
        font-size: 11px;
        color: var(--text-muted);
    }

    .chat-head-badges {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .chat-head-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .badge-role {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-role.atendente {
        background: rgba(79,142,247,.18);
        color: var(--accent);
    }

    .badge-role.usuario {
        background: rgba(34,211,165,.15);
        color: var(--success);
    }

    .btn-voltar {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 8px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        color: var(--text-muted);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: color .2s, border-color .2s;
    }

    .btn-voltar:hover {
        color: var(--text-primary);
        border-color: var(--accent);
    }

    .btn-atender {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid rgba(34, 211, 165, .35);
        background: rgba(34, 211, 165, .12);
        color: var(--success);
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .chat-assigned {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .chat-alert {
        margin: 10px 20px 0;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
    }

    .chat-alert-success {
        background: rgba(34, 211, 165, .12);
        border: 1px solid rgba(34, 211, 165, .3);
        color: var(--success);
    }

    .chat-alert-error {
        background: rgba(248, 113, 113, .12);
        border: 1px solid rgba(248, 113, 113, .3);
        color: #fca5a5;
    }

    /* ── Mensagens ──────────────────────────────────── */
    .chat-msgs {
        flex: 1;
        overflow-y: auto;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: var(--bg-body);
    }

    .msg-sistema {
        text-align: center;
        font-size: 11px;
        color: var(--text-muted);
        padding: 4px 12px;
        background: rgba(255,255,255,.04);
        border-radius: 20px;
        align-self: center;
    }

    .msg-wrap {
        display: flex;
    }

    .msg-wrap.propria  { justify-content: flex-end; }
    .msg-wrap.outra    { justify-content: flex-start; }

    .msg-balao {
        max-width: 68%;
        padding: 8px 12px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .msg-wrap.propria .msg-balao {
        background: rgba(79,142,247,.18);
        border-bottom-right-radius: 3px;
    }

    .msg-wrap.outra .msg-balao {
        background: var(--bg-card2);
        border-bottom-left-radius: 3px;
    }

    .msg-autor {
        font-size: 10px;
        font-weight: 700;
    }

    .msg-wrap.propria .msg-autor { color: var(--accent); }
    .msg-wrap.outra   .msg-autor { color: var(--success); }

    .msg-texto {
        font-size: 13px;
        line-height: 1.5;
        word-break: break-word;
        color: var(--text-primary);
    }

    .msg-hora {
        font-size: 10px;
        color: var(--text-muted);
        align-self: flex-end;
    }

    /* ── Digitando ──────────────────────────────────── */
    .chat-digitando {
        padding: 4px 20px;
        font-size: 11px;
        color: var(--text-muted);
        background: var(--bg-body);
        min-height: 22px;
        flex-shrink: 0;
    }

    /* ── Rodapé ─────────────────────────────────────── */
    .chat-footer {
        display: flex;
        gap: 8px;
        padding: 12px 20px;
        background: var(--bg-card2);
        border-top: 1px solid var(--border);
        flex-shrink: 0;
    }

    .chat-input {
        flex: 1;
        background: var(--bg-body);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text-primary);
        font-size: 13px;
        padding: 9px 14px;
        outline: none;
        transition: border-color .2s;
    }

    .chat-input:focus {
        border-color: var(--accent);
    }

    .chat-input::placeholder {
        color: var(--text-muted);
    }

    .btn-send {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 9px 18px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--accent), #2563eb);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: opacity .2s;
        white-space: nowrap;
    }

    .btn-send:hover { opacity: .88; }
    .btn-send:disabled { opacity: .45; cursor: not-allowed; }

    /* ── Overlay de conexão ─────────────────────────── */
    .chat-overlay {
        position: absolute;
        inset: 0;
        background: rgba(13,17,23,.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: var(--radius);
    }

    .chat-overlay-msg {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 28px 36px;
        text-align: center;
        color: var(--text-muted);
        font-size: 13px;
    }

    .spinner {
        width: 28px;
        height: 28px;
        border: 3px solid var(--border);
        border-top-color: var(--accent);
        border-radius: 50%;
        animation: spin .8s linear infinite;
        margin: 0 auto 12px;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .chat-container {
        position: relative;
    }
</style>
@endpush

@section('content')
<div class="chat-container">

    <div id="chat-overlay" class="chat-overlay">
        <div class="chat-overlay-msg">
            <div class="spinner"></div>
            Conectando ao chat...
        </div>
    </div>

    <div class="chat-wrap">
        <div class="chat-head">
            <div class="chat-head-info">
                <span class="chat-head-title">💬 Ticket #{{ $ticket->id }} — {{ $ticket->title }}</span>
                <span class="chat-head-sub">{{ $ticket->description }}</span>
                <span class="chat-assigned">
                    @if($ticket->attendant)
                        Em atendimento por: {{ $ticket->attendant->name }}
                    @else
                        Ainda sem atendente definido.
                    @endif
                </span>
            </div>
            <div class="chat-head-actions">
                @if(session('chat_success'))
                    <span class="chat-alert chat-alert-success">{{ session('chat_success') }}</span>
                @endif

                @if(session('chat_error'))
                    <span class="chat-alert chat-alert-error">{{ session('chat_error') }}</span>
                @endif

                <span class="badge-role {{ Auth::user()->role }}">
                    {{ Auth::user()->role === 'atendente' ? '🎧 Atendente' : '👤 Usuário' }}
                    — {{ Auth::user()->name }}
                </span>

                @if($canClaim)
                    <form method="POST" action="{{ route('tickets.take', $ticket) }}">
                        @csrf
                        <button type="submit" class="btn-atender">Assumir atendimento</button>
                    </form>
                @elseif($isMyAttendance)
                    <span class="btn-atender" style="cursor:default; opacity:.8;">Voce esta atendendo</span>
                @endif

                <a href="{{ route('tickets.index') }}" class="btn-voltar">← Voltar</a>
            </div>
        </div>

        <div class="chat-msgs" id="chat-msgs"></div>

        <div class="chat-digitando" id="chat-digitando"></div>

        <div class="chat-footer">
            <input
                type="text"
                id="chat-input"
                class="chat-input"
                placeholder="Digite sua mensagem e pressione Enter..."
                maxlength="1000"
                autocomplete="off"
                disabled
            />
            <button id="btn-send" class="btn-send" disabled>Enviar ↑</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const TOKEN    = @json($token);
    const overlay  = document.getElementById('chat-overlay');
    const msgs     = document.getElementById('chat-msgs');
    const input    = document.getElementById('chat-input');
    const btnSend  = document.getElementById('btn-send');
    const digitando = document.getElementById('chat-digitando');

    let minhaRole = null;
    let typingTimer = null;
    let socket = null;
    let isAutorizado = false;
    let currentEndpointIndex = 0;

    const scriptCandidates = [
        `${window.location.origin}/socket-chat/socket.io/socket.io.js`,
        `${window.location.protocol}//${window.location.hostname}:3030/socket.io/socket.io.js`,
    ];

    const socketCandidates = [
        { label: 'proxy', url: null, path: '/socket-chat/socket.io' },
        {
            label: 'direto:3030',
            url: `${window.location.protocol}//${window.location.hostname}:3030`,
            path: '/socket.io',
        },
    ];

    btnSend.addEventListener('click', enviar);
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); enviar(); }
    });

    input.addEventListener('input', () => {
        if (!socket || !isAutorizado) return;
        socket.emit('digitando');
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => socket.emit('parou_digitar'), 2000);
    });

    loadSocketClient(0);

    function loadSocketClient(index) {
        if (window.io) {
            conectarComFallback(0);
            return;
        }

        if (index >= scriptCandidates.length) {
            mostrarErroConexao('Não foi possível carregar o cliente do chat.');
            return;
        }

        const script = document.createElement('script');
        script.src = scriptCandidates[index];
        script.async = true;
        script.onload = () => conectarComFallback(0);
        script.onerror = () => loadSocketClient(index + 1);
        document.head.appendChild(script);
    }

    function conectarComFallback(index) {
        currentEndpointIndex = index;

        if (index >= socketCandidates.length) {
            mostrarErroConexao('Não foi possível conectar ao servidor de chat.');
            return;
        }

        const endpoint = socketCandidates[index];
        const options = {
            path: endpoint.path,
            transports: ['websocket', 'polling'],
            timeout: 6000,
            reconnectionAttempts: 1,
        };

        socket = endpoint.url ? io(endpoint.url, options) : io(options);

        const connectTimeout = setTimeout(() => {
            if (isAutorizado) return;
            socket.close();
            conectarComFallback(index + 1);
        }, 7000);

        socket.on('connect', () => {
            socket.emit('join', { token: TOKEN });
        });

        socket.on('connect_error', () => {
            clearTimeout(connectTimeout);
            if (isAutorizado) return;
            socket.close();
            conectarComFallback(index + 1);
        });

        socket.on('autorizado', ({ role }) => {
            clearTimeout(connectTimeout);
            minhaRole = role;
            isAutorizado = true;
            overlay.style.display = 'none';
            input.disabled = false;
            btnSend.disabled = false;
            input.focus();
        });

        socket.on('historico', (lista) => {
            msgs.innerHTML = '';
            lista.forEach(renderMsg);
            scrollBottom();
        });

        socket.on('mensagem', (msg) => {
            renderMsg(msg);
            scrollBottom();
        });

        socket.on('sistema', ({ mensagem }) => {
            const el = document.createElement('div');
            el.className = 'msg-sistema';
            el.textContent = mensagem;
            msgs.appendChild(el);
            scrollBottom();
        });

        socket.on('digitando', ({ name }) => {
            digitando.textContent = `${name} está digitando...`;
        });

        socket.on('parou_digitar', () => {
            digitando.textContent = '';
        });

        socket.on('erro', ({ mensagem }) => {
            clearTimeout(connectTimeout);
            mostrarErroConexao(mensagem);
        });

        // Se a conexão já estava autorizada e caiu, tenta o próximo endpoint
        socket.on('disconnect', () => {
            if (!isAutorizado) return;
            isAutorizado = false;
            input.disabled = true;
            btnSend.disabled = true;
            mostrarStatusReconexao();
            conectarComFallback((currentEndpointIndex + 1) % socketCandidates.length);
        });
    }

    function enviar() {
        if (!socket || !isAutorizado) return;
        const texto = input.value.trim();
        if (!texto) return;
        socket.emit('mensagem', { texto });
        input.value = '';
        socket.emit('parou_digitar');
    }

    function mostrarStatusReconexao() {
        overlay.style.display = 'flex';
        overlay.querySelector('.chat-overlay-msg').innerHTML =
            'Reconectando ao servidor de chat...';
    }

    function mostrarErroConexao(mensagem) {
        overlay.style.display = 'flex';
        overlay.querySelector('.chat-overlay-msg').innerHTML =
            `⚠️ ${mensagem}<br><small>Verifique se o serviço de chat está ativo e recarregue a página.</small>`;
        input.disabled = true;
        btnSend.disabled = true;
    }

    function renderMsg({ role, name, texto, timestamp }) {
        const isMinha = role === minhaRole;

        const wrap = document.createElement('div');
        wrap.className = `msg-wrap ${isMinha ? 'propria' : 'outra'}`;

        const balao = document.createElement('div');
        balao.className = 'msg-balao';

        const autor = document.createElement('span');
        autor.className = 'msg-autor';
        autor.textContent = role === 'atendente' ? `🎧 ${name}` : `👤 ${name}`;

        const texto_ = document.createElement('p');
        texto_.className = 'msg-texto';
        texto_.textContent = texto;

        const hora = document.createElement('span');
        hora.className = 'msg-hora';
        hora.textContent = new Date(timestamp).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

        balao.append(autor, texto_, hora);
        wrap.appendChild(balao);
        msgs.appendChild(wrap);
    }

    function scrollBottom() {
        msgs.scrollTop = msgs.scrollHeight;
    }
})();
</script>
@endpush
