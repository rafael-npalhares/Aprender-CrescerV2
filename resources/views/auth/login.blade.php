{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar — Aprender & Crescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-bg: #1a2238;
            --blue:       #2d6ef7;
            --blue-light: #e8f0fe;
            --page-bg:    #f0f2f5;
            --border:     #e8eaf0;
            --text:       #1a2238;
            --muted:      #8899bb;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--page-bg);
            min-height: 100vh;
            display: flex;
        }

        /* Painel esquerdo */
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
        }
        .panel-left::before {
            content: '';
            position: absolute;
            width: 380px; height: 380px;
            border-radius: 50%;
            background: rgba(45,110,247,.12);
            top: -80px; right: -100px;
        }
        .panel-left::after {
            content: '';
            position: absolute;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(45,110,247,.08);
            bottom: 60px; left: -80px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            position: relative;
            z-index: 1;
        }
        .brand-icon {
            width: 44px; height: 44px;
            background: var(--blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
        }
        .brand-name {
            font-family: 'DM Serif Display', serif;
            color: #fff;
            font-size: 1.15rem;
            line-height: 1.2;
        }
        .brand-sub {
            font-size: .72rem;
            color: var(--muted);
            letter-spacing: .04em;
        }

        .panel-tagline {
            position: relative;
            z-index: 1;
        }
        .panel-tagline h2 {
            font-family: 'DM Serif Display', serif;
            color: #fff;
            font-size: 2rem;
            line-height: 1.25;
            margin-bottom: 1rem;
        }
        .panel-tagline p {
            color: var(--muted);
            font-size: .9rem;
            line-height: 1.6;
        }

        .panel-badges {
            display: flex;
            flex-direction: column;
            gap: .75rem;
            position: relative;
            z-index: 1;
        }
        .badge-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px;
            padding: .7rem 1rem;
        }
        .badge-item .bi {
            color: var(--blue);
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .badge-item span {
            color: rgba(255,255,255,.75);
            font-size: .85rem;
        }

        /* Painel direito */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            animation: fadeUp .45s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-card h3 {
            font-family: 'DM Serif Display', serif;
            color: var(--text);
            font-size: 1.65rem;
            margin-bottom: .35rem;
        }
        .login-card .subtitle {
            color: var(--muted);
            font-size: .88rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: .82rem;
            font-weight: 600;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: .4rem;
            display: block;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.25rem;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 1rem;
            pointer-events: none;
            z-index: 2;
        }
        .form-control {
            padding-left: 2.6rem !important;
            height: 48px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: .92rem;
            color: var(--text);
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }
        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(45,110,247,.12);
            outline: none;
        }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: .8rem; color: #ef4444; display: block; margin-top: .25rem; }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 1rem;
            z-index: 2;
            padding: 0;
            line-height: 1;
        }
        .toggle-pw:hover { color: var(--blue); }

        .btn-login {
            width: 100%;
            height: 48px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: .95rem;
            letter-spacing: .02em;
            transition: background .2s, transform .15s;
            cursor: pointer;
            margin-top: .5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .btn-login:hover  { background: #1e5ce6; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .divider hr { flex: 1; border-color: var(--border); margin: 0; }
        .divider span { font-size: .78rem; color: var(--muted); white-space: nowrap; }

        .link-cadastro {
            display: block;
            text-align: center;
            font-size: .88rem;
            color: var(--muted);
        }
        .link-cadastro a {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
        }
        .link-cadastro a:hover { text-decoration: underline; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .form-check-label { font-size: .85rem; color: var(--muted); cursor: pointer; }
        .form-check-input:checked { background-color: var(--blue); border-color: var(--blue); }

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
            <h2>Bem-vindo de volta ao sistema escolar.</h2>
            <p>Acesse sua conta para acompanhar avisos, horários, reservas e muito mais.</p>
        </div>

        <div class="panel-badges">
            <div class="badge-item">
                <i class="bi bi-bell-fill"></i>
                <span>Avisos e comunicados em tempo real</span>
            </div>
            <div class="badge-item">
                <i class="bi bi-grid-3x3-gap-fill"></i>
                <span>Grade de horários sempre atualizada</span>
            </div>
            <div class="badge-item">
                <i class="bi bi-book-fill"></i>
                <span>Biblioteca e cantina integradas</span>
            </div>
        </div>
    </div>

    {{-- Painel Direito --}}
    <div class="panel-right">
        <div class="login-card">

            <h3>Entrar na conta</h3>
            <p class="subtitle">Use seu e-mail e senha cadastrados.</p>

            {{-- Erro de sessão (ex: credenciais inválidas) --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 mb-3" style="font-size:.85rem; border-radius:10px;">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            {{-- Mensagem de status (ex: "link de redefinição enviado") --}}
            @if (session('status'))
                <div class="alert alert-success py-2 mb-3" style="font-size:.85rem; border-radius:10px;">
                    <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                <label class="form-label" for="email">E-mail</label>
                <div class="input-group-custom">
                    <i class="bi bi-envelope input-icon"></i>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="seu@email.com"
                        autofocus
                        autocomplete="email"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <label class="form-label" for="senha">Senha</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock input-icon"></i>
                    <input
                        id="senha"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Sua senha"
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-pw" onclick="toggleSenha('senha','icon-senha')" aria-label="Mostrar senha">
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
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:.85rem; color:var(--blue); text-decoration:none; font-weight:600;">
                            Esqueci a senha
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Entrar
                </button>
            </form>

            <div class="divider">
                <hr><span>Não tem conta?</span><hr>
            </div>

            <p class="link-cadastro">
                <a href="{{ route('register') }}">Criar uma conta agora</a>
            </p>

        </div>
    </div>

    <script>
        function toggleSenha(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>