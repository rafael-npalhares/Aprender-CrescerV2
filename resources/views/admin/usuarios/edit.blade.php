@extends('layouts.admin')
@section('titulo', 'Editar Usuário')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Editar Usuário</h1>
        <p>Atualize os dados de <strong>{{ $usuario->name }}</strong></p>
    </div>
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">← Voltar</a>
</div>

<div style="max-width: 680px;">
    <div class="card">
        <div style="padding: 32px;">

            <div style="display:flex; align-items:center; gap:14px; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid var(--border-color);">
                <div style="width:48px;height:48px;background:#e8f0fe;border-radius:12px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.2rem;color:var(--blue-primary);">
                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:700;font-size:1rem;color:var(--text-main);">{{ $usuario->name }}</div>
                    <div style="font-size:.85rem;color:var(--text-secondary);">{{ $usuario->email }}</div>
                </div>
            </div>

            <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nome + E-mail --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label" for="name">Nome completo *</label>
                        <input type="text"
                               id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $usuario->name) }}"
                               required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">E-mail *</label>
                        <input type="email"
                               id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $usuario->email) }}"
                               required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Perfil --}}
                <div class="form-group">
                    <label class="form-label">Perfil de acesso *</label>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
                        @foreach(['admin' => ['🛡️','Admin'], 'professor' => ['🧑‍🏫','Professor'], 'aluno' => ['🎒','Aluno']] as $value => [$icon, $label])
                        <label class="role-card {{ old('role', $usuario->role) === $value ? 'selected' : '' }}"
                               for="role_{{ $value }}"
                               style="border:2px solid var(--border-color);border-radius:10px;padding:12px;cursor:pointer;text-align:center;transition:all .2s;">
                            <input type="radio" id="role_{{ $value }}" name="role"
                                   value="{{ $value }}"
                                   {{ old('role', $usuario->role) === $value ? 'checked' : '' }}
                                   style="display:none;"
                                   onchange="handleRole('{{ $value }}')">
                            <div style="font-size:1.4rem;margin-bottom:4px;">{{ $icon }}</div>
                            <div style="font-weight:700;font-size:.88rem;color:var(--text-main);">{{ $label }}</div>
                        </label>
                        @endforeach
                    </div>
                    @error('role') <div class="invalid-feedback d-block mt-1">{{ $message }}</div> @enderror
                </div>

                {{-- Matrícula — só se for aluno sem matrícula ainda --}}
                @if($usuario->role !== 'aluno' || !$usuario->aluno)
                <div class="form-group" id="campo-matricula"
                     style="{{ old('role', $usuario->role) === 'aluno' ? 'display:block' : 'display:none' }}">
                    <label class="form-label" for="matricula">Matrícula</label>
                    <input type="text"
                           id="matricula" name="matricula"
                           class="form-control @error('matricula') is-invalid @enderror"
                           value="{{ old('matricula') }}"
                           placeholder="Ex: 2026001">
                    @error('matricula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @endif

                {{-- Seção de senha --}}
                <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--border-color);">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                        <span style="font-weight:700;font-size:.95rem;color:var(--text-main);">🔒 Alterar senha</span>
                        <span style="font-size:.8rem;color:var(--text-secondary);">(deixe em branco para manter a senha atual)</span>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div class="form-group">
                            <label class="form-label" for="password">Nova senha</label>
                            <div style="position:relative;">
                                <input type="password"
                                       id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Mínimo 8 caracteres">
                                <button type="button" onclick="toggleSenha('password','ico1')"
                                        style="position:absolute;right:10px;top:50%;transform:translateY(-50%);border:none;background:none;color:var(--text-secondary);cursor:pointer;">
                                    <i class="bi bi-eye" id="ico1"></i>
                                </button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Confirmar nova senha</label>
                            <div style="position:relative;">
                                <input type="password"
                                       id="password_confirmation" name="password_confirmation"
                                       class="form-control"
                                       placeholder="Repita a nova senha">
                                <button type="button" onclick="toggleSenha('password_confirmation','ico2')"
                                        style="position:absolute;right:10px;top:50%;transform:translateY(-50%);border:none;background:none;color:var(--text-secondary);cursor:pointer;">
                                    <i class="bi bi-eye" id="ico2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botões --}}
                <div style="display:flex; gap:10px; margin-top:8px; padding-top:20px; border-top:1px solid var(--border-color);">
                    <button type="submit" class="btn btn-primary">✓ Salvar Alterações</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .role-card:hover  { border-color: var(--blue-primary) !important; background: #f0f6ff; }
    .role-card.selected { border-color: var(--blue-primary) !important; background: #e8f0fe; }
</style>
@endpush

@push('scripts')
<script>
    function handleRole(value) {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        document.querySelector(`[for="role_${value}"]`).classList.add('selected');

        const campo = document.getElementById('campo-matricula');
        if (!campo) return;
        const input = document.getElementById('matricula');
        if (value === 'aluno') {
            campo.style.display = 'block';
        } else {
            campo.style.display = 'none';
            if (input) input.required = false;
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
</script>
@endpush