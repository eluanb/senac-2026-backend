<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --gradient-start: #4facfe;
            --gradient-mid: #a855f7;
            --gradient-end: #f43bbc;
            --card-bg: #ffffff;
            --input-border: #e2e8f0;
            --input-focus: #a855f7;
            --text-primary: #1a1a2e;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --btn-gradient-start: #00d2ff;
            --btn-gradient-end: #f43bbc;
            --facebook: #3b5998;
            --twitter: #1da1f2;
            --google: #db4437;
        }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-mid) 50%, var(--gradient-end) 100%);
            position: relative;
            overflow: hidden;
        }

        /* Geometric background shapes */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 30px;
            opacity: 0.15;
            background: rgba(255, 255, 255, 0.3);
        }

        body::before {
            width: 380px;
            height: 380px;
            top: -80px;
            left: -80px;
            transform: rotate(25deg);
        }

        body::after {
            width: 300px;
            height: 300px;
            bottom: -60px;
            right: 80px;
            transform: rotate(15deg);
        }

        .bg-shape {
            position: absolute;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.12);
        }

        .bg-shape-1 {
            width: 220px;
            height: 220px;
            top: 60px;
            right: -40px;
            transform: rotate(-20deg);
        }

        .bg-shape-2 {
            width: 180px;
            height: 180px;
            bottom: 80px;
            left: 60px;
            transform: rotate(10deg);
        }

        /* Card */
        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 48px 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.18), 0 0 0 1px rgba(255, 255, 255, 0.15);
            position: relative;
            z-index: 10;
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Title */
        .card-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 36px;
            letter-spacing: -0.5px;
        }

        /* Form */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            letter-spacing: 0.01em;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 0;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            pointer-events: none;
        }

        .input-icon svg {
            width: 18px;
            height: 18px;
        }

        .form-input {
            width: 100%;
            border: none;
            border-bottom: 2px solid var(--input-border);
            padding: 10px 0 10px 28px;
            font-size: 0.95rem;
            font-family: 'Nunito', sans-serif;
            color: var(--text-primary);
            background: transparent;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .form-input::placeholder {
            color: var(--text-secondary);
            font-weight: 400;
        }

        .form-input:focus {
            border-bottom-color: var(--input-focus);
        }

        /* Alert de erro */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .alert-error ul {
            padding-left: 16px;
        }

        /* Forgot password */
        .forgot-link {
            display: block;
            text-align: right;
            margin-top: 8px;
            font-size: 0.82rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: var(--input-focus);
        }

        /* Login button */
        .btn-login {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 28px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(90deg, var(--btn-gradient-start), var(--btn-gradient-end));
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(244, 59, 188, 0.35);
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
        }

        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 12px 30px rgba(244, 59, 188, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 28px 0 20px;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Social buttons */
        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .btn-social {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
            text-decoration: none;
            transition: transform 0.18s, box-shadow 0.18s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-social:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-social.facebook {
            background: var(--facebook);
        }

        .btn-social.twitter {
            background: var(--twitter);
        }

        .btn-social.google {
            background: var(--google);
        }

        .btn-social svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }

        /* Sign up section */
        .signup-section {
            text-align: center;
            border-top: 1px solid var(--input-border);
            padding-top: 24px;
        }

        .signup-text {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .btn-signup {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--text-primary);
            text-decoration: none;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-bottom: 2px solid var(--text-primary);
            padding-bottom: 2px;
            transition: color 0.2s, border-color 0.2s;
        }

        .btn-signup:hover {
            color: var(--input-focus);
            border-color: var(--input-focus);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card {
                margin: 20px;
                padding: 36px 28px 32px;
            }
        }
    </style>
</head>

<body>

    <!-- Geometric background shapes -->
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>

    <div class="card">
        <h1 class="card-title">Login</h1>

        {{-- Exibe erros de validação --}}
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
                        placeholder="Type your username"
                        value="{{ old('email') }}"
                        required
                        autofocus>
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
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
                        placeholder="Type your password"
                        required>
                </div>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="signup-section">
            <p class="signup-text">Or Sign Up Using</p>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
            @endif
        </div>
    </div>

</body>

</html>