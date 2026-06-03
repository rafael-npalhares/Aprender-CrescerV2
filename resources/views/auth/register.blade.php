@extends('layouts.guest')

@section('titulo', 'Cadastro — Aprender & Crescer')

@section('conteudo')
<div class="guest-page">
    <div class="guest-card" style="max-width:460px;">

        <div class="guest-logo">
            <div class="logo-icon">🎓</div>
            <div class="logo-title">Criar Conta</div>
            <div class="logo-subtitle">Aprender & Crescer — Senai Joinville</div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nome completo</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Seu nome"
                    required
                    autofocus
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="seu@email.com"
                    required
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="role">Perfil</label>
                <select
                    id="role"
                    name="role"
                    class="form-select @error('role') is-invalid @enderror"
                    required
                >
                    <option value="">Selecione seu perfil</option>
                    <option value="aluno"      {{ old('role') == 'aluno' ? 'selected' : '' }}>Aluno</option>
                    <option value="professor"  {{ old('role') == 'professor' ? 'selected' : '' }}>Professor</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Senha</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Mínimo 8 caracteres"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirmar senha</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Repita a senha"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top:4px;">
                Criar conta
            </button>
        </form>

        <div class="guest-link">
            Já tem conta?
            <a href="{{ route('login') }}">Fazer login</a>
        </div>

    </div>
</div>
@endsection