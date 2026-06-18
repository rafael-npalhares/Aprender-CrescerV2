<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Professor;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('name')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:200',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'role'      => 'required|in:admin,professor,aluno',
            'matricula' => 'required_if:role,aluno|nullable|string|max:20|unique:alunos,matricula',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => $request->role,
        ]);

        if ($request->role === 'professor') {
            Professor::create(['user_id' => $user->id, 'disciplina' => null]);
        }

        if ($request->role === 'aluno') {
            Aluno::create([
                'user_id'   => $user->id,
                'matricula' => $request->matricula,
                'turma_id'  => null,
            ]);
        }

        return redirect()->route('admin.usuarios.index')
                         ->with('sucesso', 'Usuário criado com sucesso!');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'      => 'required|string|max:200',
            'email'     => 'required|email|unique:users,email,' . $usuario->id,
            'role'      => 'required|in:admin,professor,aluno',
            'password'  => 'nullable|min:8|confirmed',
            'matricula' => 'required_if:role,aluno|nullable|string|max:20|unique:alunos,matricula,' . optional($usuario->aluno)->id,
        ]);

        $dados = $request->only('name', 'email', 'role');

        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
        }

        $roleAnterior = $usuario->role;
        $roleNovo     = $request->role;

        $usuario->update($dados);

        // Se mudou de role, remove o perfil anterior
        if ($roleAnterior !== $roleNovo) {
            if ($roleAnterior === 'professor') {
                $usuario->professor?->delete();
            }

            if ($roleAnterior === 'aluno') {
                $usuario->aluno?->delete();
            }
        }

        // Cria o novo perfil se ainda não existir
        if ($roleNovo === 'professor' && !$usuario->fresh()->professor) {
            Professor::create(['user_id' => $usuario->id, 'disciplina' => null]);
        }

        if ($roleNovo === 'aluno' && !$usuario->fresh()->aluno) {
            Aluno::create([
                'user_id'   => $usuario->id,
                'matricula' => $request->matricula,
                'turma_id'  => null,
            ]);
        }

        return redirect()->route('admin.usuarios.index')
                         ->with('sucesso', 'Usuário atualizado!');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
                         ->with('sucesso', 'Usuário removido!');
    }
}