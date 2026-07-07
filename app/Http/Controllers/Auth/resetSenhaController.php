<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetSenhaController extends Controller
{

    public function formulario()
    {
        return view('auth.esqueci-senha');
    }

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

        $usuario = User::whereRaw('LOWER(email) = ?', [strtolower($request->email)])
                       ->whereRaw('LOWER(name) = ?',  [strtolower($request->name)])
                       ->first();

        if (! $usuario) {
            return back()
                ->withInput($request->only('email', 'name'))
                ->withErrors(['geral' => 'Dados incorretos. Verifique o e-mail e o nome informados.']);
        }

        session(['reset_user_id' => $usuario->id]);

        return redirect()->route('nova.senha.form');
    }

    public function novaSenhaForm()
    {
        if (! session('reset_user_id')) {
            return redirect()->route('esqueci.senha.form')
                             ->withErrors(['geral' => 'Sessão expirada. Tente novamente.']);
        }

        return view('auth.nova-senha');
    }

    public function salvar(Request $request)
    {
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

        $usuario = User::findOrFail(session('reset_user_id'));

        $usuario->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget('reset_user_id');

        return redirect()->route('login')
                         ->with('status', 'Senha alterada com sucesso! Faça login com a nova senha.');
    }
}