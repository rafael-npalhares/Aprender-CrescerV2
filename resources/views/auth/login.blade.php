@extends('layouts.guest')

@section('titulo', 'Login — Aprender & Crescer')

@section('conteudo')
<div class="guest-page">
    <div class="guest-card">

        <div class="guest-logo">
            <div class="logo-icon">🎓</div>
            <div class="logo-title">Aprender & Crescer</div>
            <div class="logo-subtitle">Sistema Escolar — Senai Joinville</div>
        </div>

        {{-- Erros gerais --}}
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                    autofocus
                >
                @error('email')
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
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4" style="margin-top: -6px;">
                <label style="display:flex; align-items:center; gap:7px; font-size:13px; color:#c4d0e8; cursor:pointer;">
                    <input type="checkbox" name="remember" class="form-check-input" style="margin:0;">
                    Lembrar-me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       style="font-size:13px; color:#2d6ef7; text-decoration:none;">
                        Esqueci a senha
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">
                Entrar no sistema
            </button>
        </form>

        @if (Route::has('register'))
            <div class="guest-link">
                Não tem conta?
                <a href="{{ route('register') }}">Criar conta</a>
            </div>
        @endif

    </div>
</div>
@endsection