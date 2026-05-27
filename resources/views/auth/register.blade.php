{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta — Aprender & Crescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-bg: #1a2238;
            --blue:       #2d6ef7;
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
            width: 240px; height: 240px;
            border-radius: 50%;
            background: rgba(45,110,247,.07);
            bottom: 80px; left: -60px;
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
        .brand-sub { font-size: .72rem; color: var(--muted); letter-spacing: .04em; }

        .panel-tagline {
            position: relative;
            z-index: 1;
        }
        .panel-tagline h2 {
            font-family: 'DM Serif Display', serif;
            color: #fff;
            font-size: 1.85rem;
            line-height: 1.25;
            margin-bottom: 1rem;
        }
        .panel-tagline p { color: var(--muted); font-size: .9rem; line-height: 1.6; }

        .steps {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .step {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .step-num {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: rgba(45,110,247,.2);
            border: 1.5px solid rgba(45,110,247,.4);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .78rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        .step-text { color: rgba(255,255,255,.7); font-size: .85rem; line-height: 1.35; }
        .step-text strong { color: #fff; }

        /* Painel direito */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-y: auto;
        }

        .register-card {
            width: 100%;
            max-width: 460px;
            padding: 1rem 0;
            animation: fadeUp .45s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .register-card h3 {
            font-family: 'DM Serif Display', serif;
            color: var(--text);
            font-size: 1.65rem;
            margin-bottom: .35rem;
        }
        .register-card .subtitle {
            color: var(--muted);
            font-size: .88rem;
            margin-bottom: 1.75rem;
        }

        .form-label {
            font-size: .78rem;
            font-weight: 600;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: .35rem;
            display: block;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.1rem;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: .95rem;
            pointer-events: none;
            z-index: 2;
        }
        .form-control,
        .form-select {
            padding-left: 2.5rem !important;
            height: 46px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: .9rem;
            color: var(--text);
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(45,110,247,.12);
            outline: none;
        }
        .form-control.is-invalid,
        .form-select.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: .78rem; color: #ef4444; display: block; margin-top: .25rem; }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: .95rem;
            z-index: 2;
            padding: 0;
            line-height: 1;
        }
        .toggle-pw:hover { color: var(--blue); }

        .section-label {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.25rem 0 1rem;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .btn-register {
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
        .btn-register:hover  { background: #1e5ce6; transform: translateY(-1px); }
        .btn-register:active { transform: translateY(0); }

        .link-login {
            display: block;
            text-align: center;
            font-size: .85rem;
            color: var(--muted);
            margin-top: 1.25rem;
        }
        .link-login a {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
        }
        .link-login a:hover { text-decoration: underline; }

        /* Barra de força da senha */
        .senha-force {
            display: flex;
            gap: 4px;
            margin-top: .3rem;
            margin-bottom: .75rem;
        }
        .senha-force span {
            flex: 1;
            height: 3px;
            border-radius: 99px;
            background: var(--border);
            transition: background .3s;
        }
        .senha-force.fraca  span:nth-child(1)                               { background: #ef4444; }
        .senha-force.media  span:nth-child(1), .senha-force.media  span:nth-child(2) { background: #f59e0b; }
        .senha-force.forte  span                                            { background: #22c55e; }

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
            <h2>Crie sua conta e comece agora.</h2>
            <p>Preencha os dados ao lado para ter acesso ao sistema escolar completo do Senai Joinville.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text"><strong>Preencha seus dados</strong><br>Nome, e-mail e senha</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text"><strong>Escolha seu perfil</strong><br>Admin, professor ou aluno</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text"><strong>Acesse o sistema</strong><br>Dashboard e todos os módulos</div>
            </div>
        </div>
    </div>

    {{-- Painel Direito --}}
    <div class="panel-right">
        <div class="register-card">

            <h3>Criar conta</h3>
            <p class="subtitle">Preencha os campos abaixo para se cadastrar.</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2 mb-3" style="font-size:.85rem; border-radius:10px;">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf

                <div class="section-label">Dados pessoais</div>

                <label class="form-label" for="name">Nome completo</label>
                <div class="input-group-custom">
                    <i class="bi bi-person input-icon"></i>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Seu nome completo"
                        autofocus
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
                        autocomplete="email"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="section-label">Segurança</div>

                <label class="form-label" for="password">Senha</label>
                <div class="input-group-custom" style="margin-bottom:.35rem;">
                    <i class="bi bi-lock input-icon"></i>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Mínimo 8 caracteres"
                        autocomplete="new-password"
                        oninput="avaliarSenha(this.value)"
                    >
                    <button type="button" class="toggle-pw" onclick="toggleSenha('password','icon-senha')" aria-label="Mostrar senha">
                        <i class="bi bi-eye" id="icon-senha"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="senha-force" id="senhaForce">
                    <span></span><span></span><span></span>
                </div>

                <label class="form-label" for="password_confirmation">Confirmar senha</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Repita a senha"
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-pw" onclick="toggleSenha('password_confirmation','icon-senha2')" aria-label="Mostrar confirmação">
                        <i class="bi bi-eye" id="icon-senha2"></i>
                    </button>
                </div>

                <div class="section-label">Perfil de acesso</div>

                <label class="form-label" for="role">Sou</label>
                <div class="input-group-custom">
                    <i class="bi bi-person-badge input-icon"></i>
                    <select
                        id="role"
                        name="role"
                        class="form-select @error('role') is-invalid @enderror"
                    >
                        <option value="">Selecione seu perfil...</option>
                        <option value="aluno"     {{ old('role') === 'aluno'     ? 'selected' : '' }}>Aluno</option>
                        <option value="professor" {{ old('role') === 'professor' ? 'selected' : '' }}>Professor</option>
                        <option value="admin"     {{ old('role') === 'admin'     ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-register">
                    <i class="bi bi-person-plus-fill"></i> Criar conta
                </button>
            </form>

            <p class="link-login">
                Já tem uma conta? <a href="{{ route('login') }}">Entrar agora</a>
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

        function avaliarSenha(val) {
            const bar = document.getElementById('senhaForce');
            bar.className = 'senha-force';
            if (!val) return;
            if (val.length < 6) {
                bar.classList.add('fraca');
            } else if (val.length < 10 || !/[A-Z]/.test(val) || !/[0-9]/.test(val)) {
                bar.classList.add('media');
            } else {
                bar.classList.add('forte');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>