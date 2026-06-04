{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Aprender & Crescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:         #0f1623;
            --sidebar-bg: #1a2238;
            --card-bg:    #1e2a3a;
            --blue:       #2d6ef7;
            --border:     rgba(255,255,255,.08);
            --text:       #e8edf5;
            --muted:      #8899bb;
            --input-bg:   #141d2e;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            color: var(--text);
        }

        /* ── LEFT PANEL ── */
        .panel-left {
            width: 420px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem 3rem 2.5rem;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            border-right: 1px solid var(--border);
        }
        .panel-left::before {
            content: '';
            position: absolute;
            width: 380px; height: 380px;
            border-radius: 50%;
            background: rgba(45,110,247,.10);
            top: -80px; right: -100px;
        }
        .panel-left::after {
            content: '';
            position: absolute;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(45,110,247,.06);
            bottom: 60px; left: -80px;
        }

        .brand {
            display: flex; align-items: center; gap: .75rem;
            position: relative; z-index: 1;
        }
        .brand-icon {
            width: 44px; height: 44px; background: var(--blue);
            border-radius: 12px; display: flex; align-items: center;
            justify-content: center; color: #fff; font-size: 1.3rem;
        }
        .brand-name {
            font-family: 'DM Serif Display', serif;
            color: #fff; font-size: 1.15rem; line-height: 1.2;
        }
        .brand-sub { font-size: .72rem; color: var(--muted); letter-spacing: .04em; }

        .panel-tagline { position: relative; z-index: 1; }
        .panel-tagline h2 {
            font-family: 'DM Serif Display', serif;
            color: #fff; font-size: 2rem; line-height: 1.25; margin-bottom: 1rem;
        }
        .panel-tagline p { color: var(--muted); font-size: .9rem; line-height: 1.6; }

        .panel-info { position: relative; z-index: 1; display: flex; flex-direction: column; gap: .75rem; }
        .info-item {
            display: flex; align-items: center; gap: .75rem;
            background: rgba(255,255,255,.04);
            border: 1px solid var(--border);
            border-radius: 10px; padding: .7rem 1rem;
        }
        .info-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--blue); flex-shrink: 0;
        }
        .info-item span { color: rgba(255,255,255,.65); font-size: .85rem; }

        /* ── RIGHT PANEL ── */
        .panel-right {
            flex: 1; display: flex;
            align-items: center; justify-content: center; padding: 2rem;
        }

        .card-form {
            width: 100%; max-width: 420px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem 2.25rem;
            animation: fadeUp .45s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-icon {
            width: 56px; height: 56px;
            background: rgba(45,110,247,.15);
            border: 1px solid rgba(45,110,247,.3);
            border-radius: 16px; display: flex; align-items: center;
            justify-content: center; font-size: 1.6rem; color: var(--blue);
            margin-bottom: 1.25rem;
        }

        .card-form h3 {
            font-family: 'DM Serif Display', serif;
            color: var(--text); font-size: 1.65rem; margin-bottom: .35rem;
        }
        .card-form .subtitle {
            color: var(--muted); font-size: .88rem;
            line-height: 1.55; margin-bottom: 2rem;
        }

        .form-label {
            font-size: .82rem; font-weight: 600; color: var(--muted);
            text-transform: uppercase; letter-spacing: .05em; margin-bottom: .4rem;
        }

        .input-wrap { position: relative; margin-bottom: 1.25rem; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--muted); font-size: 1rem; pointer-events: none; z-index: 2;
        }
        .form-control {
            padding-left: 2.6rem !important;
            height: 48px;
            border: 1.5px solid var(--border);
            border-radius: 10px; font-size: .92rem;
            color: var(--text);
            background: var(--input-bg);
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control::placeholder { color: #3d4f6e; }
        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(45,110,247,.15);
            outline: none;
            background: var(--input-bg);
            color: var(--text);
        }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: .8rem; color: #ef4444; }

        .toggle-pw {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            border: none; background: none;
            color: var(--muted); cursor: pointer; z-index: 2;
            transition: color .15s;
        }
        .toggle-pw:hover { color: var(--blue); }

        .remember-row {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 1.5rem;
        }
        .form-check-input {
            background-color: var(--input-bg);
            border-color: var(--border);
        }
        .form-check-input:checked {
            background-color: var(--blue);
            border-color: var(--blue);
        }
        .form-check-label { color: var(--muted); font-size: .85rem; }

        .forgot-link {
            text-decoration: none; color: var(--blue);
            font-size: .85rem; font-weight: 600;
            transition: opacity .15s;
        }
        .forgot-link:hover { opacity: .8; }

        .btn-login {
            width: 100%; height: 48px; background: var(--blue);
            color: #fff; border: none; border-radius: 10px;
            font-weight: 600; font-size: .95rem; letter-spacing: .02em;
            transition: background .2s, transform .15s; cursor: pointer;
        }
        .btn-login:hover { background: #1e5ce6; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }

        .alert-danger {
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.25);
            color: #f87171; border-radius: 10px; font-size: .85rem;
        }
        .alert-success {
            background: rgba(34,197,94,.1);
            border: 1px solid rgba(34,197,94,.25);
            color: #4ade80; border-radius: 10px; font-size: .85rem;
        }

        @media (max-width: 768px) { .panel-left { display: none; } }
    </style>
</head>
<body>

    {{-- Painel Esquerdo --}}
    <div class="panel-left">
        <div class="brand">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
                <div class="brand-name">Aprender & Crescer</div>
                <div class="brand-sub">Senai Joinville</div>
            </div>
        </div>

        <div class="panel-tagline">
            <h2>Bem-vindo ao sistema.</h2>
            <p>Área destinada a alunos, professores e colaboradores. Faça login para acessar os recursos do sistema.</p>
        </div>

        <div class="panel-info">
            <div class="info-item">
                <div class="info-dot"></div>
                <span>Gestão de usuários e turmas</span>
            </div>
            <div class="info-item">
                <div class="info-dot"></div>
                <span>Reservas e horários integrados</span>
            </div>
            <div class="info-item">
                <div class="info-dot"></div>
                <span>Biblioteca e cantina disponíveis</span>
            </div>
        </div>
    </div>

    {{-- Painel Direito --}}
    <div class="panel-right">
        <div class="card-form">

            <div class="card-icon">
                <i class="bi bi-shield-lock"></i>
            </div>

            <h3>Acessar sistema</h3>
            <p class="subtitle">Informe suas credenciais para continuar.</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2 mb-3">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success py-2 mb-3">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <label class="form-label">E-mail</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="seu@email.com"
                           autofocus autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <label class="form-label">Senha</label>
                <div class="input-wrap">
                    <i class="bi bi-lock input-icon"></i>
                    <input id="senha" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••"
                           autocomplete="current-password">
                    <button type="button" class="toggle-pw" onclick="toggleSenha()">
                        <i class="bi bi-eye" id="icon-senha"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Lembrar de mim</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Esqueci a senha
                    </a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                </button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSenha() {
            const input = document.getElementById('senha');
            const icon  = document.getElementById('icon-senha');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>