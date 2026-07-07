<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Professor;
use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('aluno')->orderBy('name')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $turmas = Turma::where('ativa', true)->orderBy('serie')->orderBy('turma')->get();
        return view('admin.usuarios.create', compact('turmas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:200',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'role'      => 'required|in:admin,professor,aluno,gerente',
            'matricula' => 'required_if:role,aluno|nullable|string|max:20|unique:alunos,matricula',
            'turma_id'  => 'nullable|exists:turmas,id',
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
                'turma_id'  => $request->turma_id,
            ]);
        }

        // 'gerente' não tem tabela de perfil própria — o campo role no
        // próprio users já é suficiente para o middleware role:gerente.

        return redirect()->route('admin.usuarios.index')
                         ->with('sucesso', 'Usuário criado com sucesso!');
    }

    public function edit(User $usuario)
    {
        $turmas = Turma::where('ativa', true)->orderBy('serie')->orderBy('turma')->get();
        return view('admin.usuarios.edit', compact('usuario', 'turmas'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'      => 'required|string|max:200',
            'email'     => 'required|email|unique:users,email,' . $usuario->id,
            'role'      => 'required|in:admin,professor,aluno,gerente',
            'password'  => 'nullable|min:8|confirmed',
            'matricula' => 'required_if:role,aluno|nullable|string|max:20|unique:alunos,matricula,' . optional($usuario->aluno)->id,
            'turma_id'  => 'nullable|exists:turmas,id',
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
            // 'gerente' e 'admin' não têm tabela de perfil própria, nada a remover
        }

        // Professor: cria perfil se não existir
        if ($roleNovo === 'professor' && !$usuario->fresh()->professor) {
            Professor::create(['user_id' => $usuario->id, 'disciplina' => null]);
        }

        // Aluno: cria perfil se não existir, ou atualiza turma/matrícula se já existir
        if ($roleNovo === 'aluno') {
            $alunoAtual = $usuario->fresh()->aluno;

            if (!$alunoAtual) {
                Aluno::create([
                    'user_id'   => $usuario->id,
                    'matricula' => $request->matricula,
                    'turma_id'  => $request->turma_id,
                ]);
            } else {
                // Atualiza turma sempre que enviada
                $dadosAluno = ['turma_id' => $request->turma_id];

                // Atualiza matrícula apenas se enviada (evita sobrescrever com null)
                if ($request->filled('matricula')) {
                    $dadosAluno['matricula'] = $request->matricula;
                }

                $alunoAtual->update($dadosAluno);
            }
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