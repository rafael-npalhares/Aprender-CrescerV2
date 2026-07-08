{{-- resources/views/auth/reset-password.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha — Aprender & Crescer</title>

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
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.3rem;
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

        .panel-items { position: relative; z-index: 1; display: flex; flex-direction: column; gap: .75rem; }
        .panel-item {
            display: flex; align-items: center; gap: .75rem;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px; padding: .7rem 1rem;
        }
        .panel-item .bi { color: var(--blue); font-size: 1.1rem; flex-shrink: 0; }
        .panel-item span { color: rgba(255,255,255,.75); font-size: .85rem; }

        .panel-right {
            flex: 1; display: flex;
            align-items: center; justify-content: center; padding: 2rem;
        }

        .reset-card {
            width: 100%; max-width: 400px;
            animation: fadeUp .45s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-icon {
            width: 56px; height: 56px;
            background: #e8f0fe; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: var(--blue);
            margin-bottom: 1.25rem;
        }

        .reset-card h3 {
            font-family: 'DM Serif Display', serif;
            color: var(--text); font-size: 1.65rem; margin-bottom: .35rem;
        }
        .reset-card .subtitle {
            color: var(--muted); font-size: .88rem;
            line-height: 1.55; margin-bottom: 2rem;
        }

        .form-label {
            font-size: .82rem; font-weight: 600; color: var(--text);
            text-transform: uppercase; letter-spacing: .05em; margin-bottom: .4rem;
        }

        .input-group-custom { position: relative; margin-bottom: 1.25rem; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--muted); font-size: 1rem; pointer-events: none; z-index: 2;
        }
        .form-control {
            padding-left: 2.6rem !important;
            height: 48px; border: 1.5px solid var(--border);
            border-radius: 10px; font-size: .92rem; color: var(--text);
            background: #fff; transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(45,110,247,.12); outline: none;
        }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: .8rem; }

        .toggle-pw {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--muted); font-size: 1rem; z-index: 2; padding: 0;
        }
        .toggle-pw:hover { color: var(--blue); }

        .senha-force {
            margin-top: .3rem; margin-bottom: 1rem;
            display: flex; gap: 4px;
        }
        .senha-force span {
            flex: 1; height: 3px; border-radius: 99px;
            background: var(--border); transition: background .3s;
        }
        .senha-force.fraca  span:nth-child(1) { background: #ef4444; }
        .senha-force.media  span:nth-child(1),
        .senha-force.media  span:nth-child(2) { background: #f59e0b; }
        .senha-force.forte  span { background: #22c55e; }

        .btn-salvar {
            width: 100%; height: 48px; background: var(--blue);
            color: #fff; border: none; border-radius: 10px;
            font-weight: 600; font-size: .95rem; letter-spacing: .02em;
            transition: background .2s, transform .15s; cursor: pointer;
        }
        .btn-salvar:hover { background: #1e5ce6; transform: translateY(-1px); }
        .btn-salvar:active { transform: translateY(0); }

        .link-voltar {
            display: block; text-align: center;
            font-size: .85rem; color: var(--muted);
            margin-top: 1.25rem; text-decoration: none; transition: color .15s;
        }
        .link-voltar:hover { color: var(--blue); }

        @media (max-width: 768px) { .panel-left { display: none; } }
    </style>
</head>
<body>

    <div class="panel-left">
        <div class="brand">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
                <div class="brand-name">Aprender & Crescer</div>
                <div class="brand-sub">Senai Joinville</div>
            </div>
        </div>

        <div class="panel-tagline">
            <h2>Crie uma nova senha segura.</h2>
            <p>Escolha uma senha forte para proteger o acesso à sua conta no sistema escolar.</p>
        </div>

        <div class="panel-items">
            <div class="panel-item">
                <i class="bi bi-shield-check"></i>
                <span>Use pelo menos 8 caracteres</span>
            </div>
            <div class="panel-item">
                <i class="bi bi-asterisk"></i>
                <span>Misture letras maiúsculas e números</span>
            </div>
            <div class="panel-item">
                <i class="bi bi-lock-fill"></i>
                <span>Não reutilize senhas antigas</span>
            </div>
        </div>
    </div>

    <div class="panel-right">
        <div class="reset-card">

            <div class="card-icon">
                <i class="bi bi-key"></i>
            </div>

            <h3>Criar nova senha</h3>
            <p class="subtitle">Digite e confirme sua nova senha abaixo.</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2 mb-3" style="font-size:.85rem;border-radius:10px;">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            {{-- action="{{ route('password.store') }}" chama o NewPasswordController@store --}}
            <form method="POST" action="{{ route('password.store') }}" novalidate>
                @csrf

                {{-- Token oculto — obrigatório, vem na URL do e-mail --}}
                {{-- Sem ele o Laravel rejeita a requisição --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- E-mail (oculto também, vem como parâmetro na URL) --}}
                <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                {{-- Nova senha --}}
                <label class="form-label">Nova senha</label>
                <div class="input-group-custom" style="margin-bottom:.4rem;">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password"
                           name="password"
                           id="senha"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Mínimo 8 caracteres"
                           autocomplete="new-password"
                           oninput="avaliarSenha(this.value)"
                           autofocus>
                    <button type="button" class="toggle-pw" onclick="toggleSenha('senha','icon-senha')">
                        <i class="bi bi-eye" id="icon-senha"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="senha-force" id="senhaForce">
                    <span></span><span></span><span></span>
                </div>
                
                <label class="form-label">Confirmar nova senha</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password"
                           name="password_confirmation"
                           id="senha2"
                           class="form-control"
                           placeholder="Repita a nova senha"
                           autocomplete="new-password">
                    <button type="button" class="toggle-pw" onclick="toggleSenha('senha2','icon-senha2')">
                        <i class="bi bi-eye" id="icon-senha2"></i>
                    </button>
                </div>

                <button type="submit" class="btn-salvar">
                    <i class="bi bi-check-lg me-2"></i>Salvar nova senha
                </button>
            </form>

            <a href="{{ route('login') }}" class="link-voltar">
                <i class="bi bi-arrow-left me-1"></i>Voltar para o login
            </a>

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