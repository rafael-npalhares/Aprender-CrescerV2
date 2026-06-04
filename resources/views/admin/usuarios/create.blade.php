{{-- resources/views/admin/usuarios/create.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário — Aprender & Crescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --sidebar-bg: #1a2238; --blue: #2d6ef7; --page-bg: #f0f2f5;
            --border: #e8eaf0; --text: #1a2238; --muted: #8899bb;
        }
        body { font-family: 'DM Sans', sans-serif; background: var(--page-bg); min-height: 100vh; display: flex; }

        .panel-left {
            width: 420px; min-height: 100vh; background: var(--sidebar-bg);
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 3rem 3rem 2.5rem; position: relative; overflow: hidden; flex-shrink: 0;
        }
        .panel-left::before {
            content: ''; position: absolute; width: 380px; height: 380px;
            border-radius: 50%; background: rgba(45,110,247,.12); top: -80px; right: -100px;
        }
        .panel-left::after {
            content: ''; position: absolute; width: 260px; height: 260px;
            border-radius: 50%; background: rgba(45,110,247,.08); bottom: 60px; left: -80px;
        }
        .brand { display: flex; align-items: center; gap: .75rem; position: relative; z-index: 1; }
        .brand-icon {
            width: 44px; height: 44px; background: var(--blue); border-radius: 12px;
            display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.3rem;
        }
        .brand-name { font-family: 'DM Serif Display', serif; color: #fff; font-size: 1.15rem; line-height: 1.2; }
        .brand-sub  { font-size: .72rem; color: var(--muted); letter-spacing: .04em; }

        .panel-tagline { position: relative; z-index: 1; }
        .panel-tagline h2 { font-family: 'DM Serif Display', serif; color: #fff; font-size: 2rem; line-height: 1.25; margin-bottom: 1rem; }
        .panel-tagline p  { color: var(--muted); font-size: .9rem; line-height: 1.6; }

        .panel-steps { position: relative; z-index: 1; display: flex; flex-direction: column; gap: .75rem; }
        .step-item {
            display: flex; align-items: center; gap: .75rem;
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px; padding: .7rem 1rem;
        }
        .step-num {
            width: 26px; height: 26px; border-radius: 50%; background: var(--blue); color: #fff;
            font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .step-item span { color: rgba(255,255,255,.75); font-size: .85rem; }

        .panel-right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem; overflow-y: auto; }
        .register-card { width: 100%; max-width: 420px; animation: fadeUp .45s ease both; padding: 1rem 0; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }

        .register-card h3      { font-family: 'DM Serif Display', serif; color: var(--text); font-size: 1.65rem; margin-bottom: .35rem; }
        .register-card .subtitle { color: var(--muted); font-size: .88rem; line-height: 1.55; margin-bottom: 1.75rem; }

        .section-label {
            font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
            color: var(--muted); display: flex; align-items: center; gap: .75rem; margin: 1.25rem 0 1rem;
        }
        .section-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        .form-label { font-size: .82rem; font-weight: 600; color: var(--text); text-transform: uppercase; letter-spacing: .05em; margin-bottom: .4rem; }

        .input-group-custom { position: relative; margin-bottom: 1.1rem; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 1rem; pointer-events: none; z-index: 2; }

        .form-control, .form-select {
            padding-left: 2.6rem !important; height: 48px; border: 1.5px solid var(--border);
            border-radius: 10px; font-size: .92rem; color: var(--text); background: #fff;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(45,110,247,.12); outline: none; }
        .form-control.is-invalid, .form-select.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: .8rem; }

        .toggle-pw {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: var(--muted); font-size: 1rem; z-index: 2; padding: 0;
        }
        .toggle-pw:hover { color: var(--blue); }

        .senha-force { margin-top: .3rem; margin-bottom: .75rem; display: flex; gap: 4px; }
        .senha-force span { flex: 1; height: 3px; border-radius: 99px; background: var(--border); transition: background .3s; }
        .senha-force.fraca span:nth-child(1) { background: #ef4444; }
        .senha-force.media span:nth-child(1),
        .senha-force.media span:nth-child(2) { background: #f59e0b; }
        .senha-force.forte span { background: #22c55e; }

        /* campo matrícula — animação suave */
        #campo-matricula {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height .35s ease, opacity .3s ease;
        }
        #campo-matricula.visivel {
            max-height: 120px;
            opacity: 1;
        }

        .btn-register {
            width: 100%; height: 48px; background: var(--blue); color: #fff; border: none; border-radius: 10px;
            font-weight: 600; font-size: .95rem; letter-spacing: .02em;
            transition: background .2s, transform .15s; cursor: pointer; margin-top: .5rem;
        }
        .btn-register:hover  { background: #1e5ce6; transform: translateY(-1px); }
        .btn-register:active { transform: translateY(0); }

        .link-voltar {
            display: block; text-align: center; font-size: .85rem;
            color: var(--muted); margin-top: 1.25rem; text-decoration: none; transition: color .15s;
        }
        .link-voltar:hover { color: var(--blue); }

        @media (max-width: 768px) { .panel-left { display: none; } }
    </style>
</head>
<body>

{{-- PAINEL ESQUERDO --}}
<div class="panel-left">
    <div class="brand">
        <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
            <div class="brand-name">Aprender & Crescer</div>
            <div class="brand-sub">Senai Joinville</div>
        </div>
    </div>

    <div class="panel-tagline">
        <h2>Cadastrar novo usuário.</h2>
        <p>Preencha os dados ao lado para criar uma conta de aluno, professor ou administrador no sistema.</p>
    </div>

    <div class="panel-steps">
        <div class="step-item"><div class="step-num">1</div><span>Preencha os dados pessoais do usuário</span></div>
        <div class="step-item"><div class="step-num">2</div><span>Defina o perfil de acesso</span></div>
        <div class="step-item"><div class="step-num">3</div><span>Usuário criado e pronto para logar</span></div>
    </div>
</div>

{{-- PAINEL DIREITO —  FORMULÁRIO --}}
<div class="panel-right">
    <div class="register-card">

        <h3>Criar usuário</h3>
        <p class="subtitle">Preencha os campos abaixo para cadastrar um novo usuário.</p>

        {{-- Erros de validação --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2 mb-3" style="font-size:.85rem;border-radius:10px;">
                <i class="bi bi-exclamation-circle me-2"></i>
                @foreach ($errors->all() as $error){{ $error }}<br>@endforeach
            </div>
        @endif

        {{-- ✅ FIX 1: action aponta para admin.usuarios.store --}}
        <form action="{{ route('admin.usuarios.store') }}" method="POST" novalidate>
            @csrf

            {{-- DADOS PESSOAIS --}}
            <div class="section-label">Dados pessoais</div>

            <label class="form-label">Nome completo</label>
            <div class="input-group-custom">
                <i class="bi bi-person input-icon"></i>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="Nome completo do usuário"
                       autofocus autocomplete="name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <label class="form-label">E-mail</label>
            <div class="input-group-custom">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="email@exemplo.com"
                       autocomplete="email">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- PERFIL --}}
            <div class="section-label">Perfil de acesso</div>

            <label class="form-label">Perfil</label>
            <div class="input-group-custom">
                <i class="bi bi-person-badge input-icon"></i>
                {{-- ✅ FIX 2: opção admin adicionada --}}
                <select name="role" id="selectRole"
                        class="form-select @error('role') is-invalid @enderror">
                    <option value="">Selecione o perfil...</option>
                    <option value="aluno"     {{ old('role') === 'aluno'     ? 'selected' : '' }}>Aluno</option>
                    <option value="professor" {{ old('role') === 'professor' ? 'selected' : '' }}>Professor</option>
                    <option value="admin"     {{ old('role') === 'admin'     ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- ✅ FIX 3: campo matrícula aparece só quando role = aluno --}}
            <div id="campo-matricula">
                <label class="form-label">Matrícula</label>
                <div class="input-group-custom">
                    <i class="bi bi-card-text input-icon"></i>
                    <input type="text" name="matricula"
                           class="form-control @error('matricula') is-invalid @enderror"
                           value="{{ old('matricula') }}"
                           placeholder="Ex: 2024001">
                    @error('matricula')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- SEGURANÇA --}}
            <div class="section-label">Segurança</div>

            <label class="form-label">Senha</label>
            <div class="input-group-custom" style="margin-bottom:.4rem;">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" id="senha"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Mínimo 8 caracteres"
                       autocomplete="new-password"
                       oninput="avaliarSenha(this.value)">
                <button type="button" class="toggle-pw" onclick="toggleSenha('senha','icon-senha')">
                    <i class="bi bi-eye" id="icon-senha"></i>
                </button>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="senha-force" id="senhaForce"><span></span><span></span><span></span></div>

            <label class="form-label">Confirmar senha</label>
            <div class="input-group-custom">
                <i class="bi bi-lock-fill input-icon"></i>
                <input type="password" name="password_confirmation" id="senha2"
                       class="form-control"
                       placeholder="Repita a senha"
                       autocomplete="new-password">
                <button type="button" class="toggle-pw" onclick="toggleSenha('senha2','icon-senha2')">
                    <i class="bi bi-eye" id="icon-senha2"></i>
                </button>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus-fill me-2"></i>Criar usuário
            </button>
        </form>

        <a href="{{ route('admin.dashboard') }}" class="link-voltar">
            <i class="bi bi-arrow-left me-1"></i>Voltar ao painel
        </a>

    </div>
</div>

<script>
    // ── Mostrar/ocultar matrícula conforme perfil selecionado ──
    const selectRole      = document.getElementById('selectRole');
    const campoMatricula  = document.getElementById('campo-matricula');

    function toggleMatricula() {
        if (selectRole.value === 'aluno') {
            campoMatricula.classList.add('visivel');
        } else {
            campoMatricula.classList.remove('visivel');
            campoMatricula.querySelector('input').value = '';
        }
    }

    selectRole.addEventListener('change', toggleMatricula);

    // Mantém visível ao voltar com old() preenchido
    toggleMatricula();

    // ── Toggle visibilidade de senha ──
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

    // ── Força da senha ──
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