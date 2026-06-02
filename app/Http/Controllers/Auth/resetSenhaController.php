<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetSenhaController extends Controller
{
    /**
     * Exibe o formulário de verificação (e-mail + nome)
     */
    public function formulario()
    {
        return view('auth.esqueci-senha');
    }

    /**
     * Verifica se o e-mail e o nome batem com algum usuário no banco.
     * Se sim, guarda o ID na sessão e manda pra tela de nova senha.
     * Se não, volta com erro.
     */
    public function verificar(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'name'  => ['required', 'string'],
        ], [
            'email.required' => 'Informe o e-mail cadastrado.',
            'email.email'    => 'E-mail inválido.',
            'name.required'  => 'Informe o nome completo.',
        ]);

        // Busca o usuário pelo e-mail (case-insensitive) e nome
        $usuario = User::whereRaw('LOWER(email) = ?', [strtolower($request->email)])
                       ->whereRaw('LOWER(name) = ?',  [strtolower($request->name)])
                       ->first();

        // Se não encontrar, volta com erro genérico
        // (não diz se foi o e-mail ou o nome que errou — mais seguro)
        if (! $usuario) {
            return back()
                ->withInput($request->only('email', 'name'))
                ->withErrors(['geral' => 'Dados incorretos. Verifique o e-mail e o nome informados.']);
        }

        // Guarda o ID na sessão pra usar na próxima etapa
        // O usuário não consegue manipular isso porque fica no servidor
        session(['reset_user_id' => $usuario->id]);

        return redirect()->route('nova.senha.form');
    }

    /**
     * Exibe o formulário de nova senha.
     * Se não tiver o ID na sessão, redireciona de volta pro início.
     */
    public function novaSenhaForm()
    {
        // Garante que só chega aqui quem passou pela verificação
        if (! session('reset_user_id')) {
            return redirect()->route('esqueci.senha.form')
                             ->withErrors(['geral' => 'Sessão expirada. Tente novamente.']);
        }

        return view('auth.nova-senha');
    }

    /**
     * Salva a nova senha no banco.
     */
    public function salvar(Request $request)
    {
        // Garante que a sessão ainda existe
        if (! session('reset_user_id')) {
            return redirect()->route('esqueci.senha.form')
                             ->withErrors(['geral' => 'Sessão expirada. Tente novamente.']);
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required'  => 'Informe a nova senha.',
            'password.min'       => 'A senha precisa ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        // Busca o usuário pelo ID guardado na sessão
        $usuario = User::findOrFail(session('reset_user_id'));

        // Salva a nova senha com hash (nunca salvar senha em texto puro)
        $usuario->update([
            'password' => Hash::make($request->password),
        ]);

        // Limpa a sessão — sem isso o usuário poderia voltar e trocar a senha de novo
        session()->forget('reset_user_id');

        // Redireciona pro login com mensagem de sucesso
        return redirect()->route('login')
                         ->with('status', 'Senha alterada com sucesso! Faça login com a nova senha.');
    }
}