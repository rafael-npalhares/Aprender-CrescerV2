<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Professor;
use App\Models\Aluno;

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
            'name'     => 'required|string|max:200',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,professor,aluno',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // cast do model ja criptografa
            'role'     => $request->role,
        ]);
        if ($request->role === 'professor') {
            Professor::create(['user_id' => $user->id, 'disciplina' => null]);
        }

        if ($request->role === 'aluno') {
            Aluno::create(['user_id' => $user->id, 'matricula' => $request->matricula, 'turma_id' => null]);
        };

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
            'name'  => 'required|string|max:200',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'role'  => 'required|in:admin,professor,aluno',
        ]);
        if ($request->role === 'professor' && !$usuario->professor) {
            Professor::create(['user_id' => $usuario->id, 'disciplina' => null]);
        }
        if ($request->role === 'aluno' && !$usuario->aluno) {
            Aluno::create(['user_id' => $usuario->id, 'matricula' => $request->matricula, 'turma_id' => null]);
        }

        $usuario->update($request->only('name', 'email', 'role'));

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