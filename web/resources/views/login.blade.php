@extends('layouts.guest')

@section('title', 'Login | E-ticket')

@section('body-style')
    font-family: 'Nunito', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4facfe 0%, #a855f7 50%, #f43bbc 100%);
    position: relative;
    overflow: hidden;
@endsection

@push('head')
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('css/pages/login.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="bg-shape bg-shape-1"></div>
<div class="bg-shape bg-shape-2"></div>

<div class="card">
    <h1 class="card-title">Login</h1>

    @if ($errors->any())
    <div class="alert-error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('auth') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">E-mail</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input"
                    placeholder="Digite seu e-mail"
                    value="{{ old('email') }}"
                    required
                    autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Senha</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    placeholder="Digite sua senha"
                    required>
            </div>
        </div>

        <button type="submit" class="btn-login">Entrar</button>
    </form>

    <div class="signup-section">
        <p class="signup-text">Acesso administrativo</p>
        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="btn-signup">Criar Conta</a>
        @endif
    </div>
</div>
@endsection
