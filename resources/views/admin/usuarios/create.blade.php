@extends('layouts.admin')
@section('titulo', 'Novo Usuário')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Novo Usuário</h1>
        <p>Preencha os dados para criar um novo usuário</p>
    </div>
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">← Voltar</a>
</div>

<div style="max-width: 680px;">
    <div class="card">
        <div style="padding: 32px;">

            <div style="display:flex; align-items:center; gap:14px; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid var(--border-color);">
                <div style="width:48px;height:48px;background:var(--badge-blue-bg);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">👤</div>
                <div>
                    <div style="font-weight:700;font-size:1rem;color:var(--text-main);">Dados do usuário</div>
                    <div style="font-size:.85rem;color:var(--text-secondary);">Todos os campos marcados com * são obrigatórios</div>
                </div>
            </div>

            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf

                {{-- Nome + E-mail --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label" for="name">Nome completo *</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Nome completo"
                               required autofocus>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">E-mail *</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="email@exemplo.com"
                               required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Perfil --}}
                <div class="form-group">
                    <label class="form-label">Perfil de acesso *</label>
                    <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:10px;">
                        @foreach([
                            'admin'     => ['🛡️', 'Admin', 'Acesso total ao sistema'],
                            'professor' => ['🧑‍🏫', 'Professor', 'Reservas e horários'],
                            'aluno'     => ['🎒', 'Aluno', 'Avisos e biblioteca'],
                            'gerente'   => ['🍔', 'Gerente', 'Gerencia a cantina'],
                        ] as $value => [$icon, $label, $desc])
                        <label class="role-card {{ old('role') === $value ? 'selected' : '' }}"
                               for="role_{{ $value }}"
                               style="border:2px solid var(--border-color);border-radius:10px;padding:14px;cursor:pointer;text-align:center;transition:all .2s;">
                            <input type="radio" id="role_{{ $value }}" name="role"
                                   value="{{ $value }}"
                                   {{ old('role') === $value ? 'checked' : '' }}
                                   style="display:none;"
                                   onchange="handleRole('{{ $value }}')">
                            <div style="font-size:1.6rem;margin-bottom:6px;">{{ $icon }}</div>
                            <div style="font-weight:700;font-size:.9rem;color:var(--text-main);">{{ $label }}</div>
                            <div style="font-size:.75rem;color:var(--text-secondary);margin-top:2px;">{{ $desc }}</div>
                        </label>
                        @endforeach
                    </div>
                    @error('role') <div class="invalid-feedback d-block mt-1">{{ $message }}</div> @enderror
                </div>

                {{-- Campos exclusivos de Aluno — ocultos por padrão --}}
                <div id="campos-aluno" style="display:none;">

                    {{-- Matrícula --}}
                    <div class="form-group">
                        <label class="form-label" for="matricula">Matrícula *</label>
                        <input type="text" id="matricula" name="matricula"
                               class="form-control @error('matricula') is-invalid @enderror"
                               value="{{ old('matricula') }}"
                               placeholder="Ex: 2026001">
                        @error('matricula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Data de nascimento --}}
                    <div class="form-group">
                        <label class="form-label" for="data_nascimento">Data de nascimento *</label>
                        <input type="date" id="data_nascimento" name="data_nascimento"
                               class="form-control @error('data_nascimento') is-invalid @enderror"
                               value="{{ old('data_nascimento') }}"
                               max="{{ now()->format('Y-m-d') }}">
                        @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Turma --}}
                    <div class="form-group">
                        <label class="form-label" for="turma_id">Turma</label>
                        <select id="turma_id" name="turma_id"
                                class="form-control @error('turma_id') is-invalid @enderror">
                            <option value="">Sem turma atribuída</option>
                            @foreach($turmas as $turma)
                                <option value="{{ $turma->id }}"
                                        {{ old('turma_id') == $turma->id ? 'selected' : '' }}>
                                    {{ $turma->serie }}º ano {{ $turma->turma }} — {{ ucfirst($turma->turno) }} ({{ $turma->ano_letivo }})
                                </option>
                            @endforeach
                        </select>
                        @error('turma_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                {{-- Senha --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label" for="password">Senha *</label>
                        <div style="position:relative;">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres" required>
                            <button type="button" onclick="toggleSenha('password','ico1')"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);border:none;background:none;color:var(--text-secondary);cursor:pointer;">
                                <i class="bi bi-eye" id="ico1"></i>
                            </button>
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirmar senha *</label>
                        <div style="position:relative;">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control" placeholder="Repita a senha" required>
                            <button type="button" onclick="toggleSenha('password_confirmation','ico2')"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);border:none;background:none;color:var(--text-secondary);cursor:pointer;">
                                <i class="bi bi-eye" id="ico2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-top:8px; padding-top:20px; border-top:1px solid var(--border-color);">
                    <button type="submit" class="btn btn-primary">✓ Criar Usuário</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function handleRole(value) {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        document.querySelector(`[for="role_${value}"]`).classList.add('selected');

        const camposAluno    = document.getElementById('campos-aluno');
        const matricula      = document.getElementById('matricula');
        const dataNascimento = document.getElementById('data_nascimento');

        if (value === 'aluno') {
            camposAluno.style.display = 'block';
            matricula.required = true;
            dataNascimento.required = true;
        } else {
            camposAluno.style.display = 'none';
            matricula.required = false;
            dataNascimento.required = false;
        }
    }

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

    document.addEventListener('DOMContentLoaded', function () {
        const checked = document.querySelector('input[name="role"]:checked');
        if (checked) handleRole(checked.value);
    });
</script>
@endpush