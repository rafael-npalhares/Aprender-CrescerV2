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
            'name'       => 'required|string|max:200',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8|confirmed',
            // confirmed = exige que exista um campo password_confirmation igual
            'role'       => 'required|in:admin,professor,aluno',
            'matricula'  => 'required_if:role,aluno|nullable|string|max:20|unique:alunos,matricula',
            // required_if:role,aluno = obrigatório só quando o perfil for aluno
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // cast 'hashed' no Model criptografa
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
            'name'  => 'required|string|max:200',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'role'  => 'required|in:admin,professor,aluno',

            // Senha é opcional no update — só valida se o admin preencheu
            'password' => 'nullable|min:8|confirmed',
            // confirmed = exige password_confirmation igual, mas só se password for preenchido

            'matricula' => 'required_if:role,aluno|nullable|string|max:20|unique:alunos,matricula,' . optional($usuario->aluno)->id,
            // unique com exceção do próprio registro de aluno, igual ao e-mail
        ]);

        // Monta os dados que serão atualizados
        $dados = $request->only('name', 'email', 'role');

        // Só atualiza a senha se o admin preencheu o campo
        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
            // Hash::make() porque aqui estamos passando já processado,
            // diferente do store() onde o cast do Model cuida disso
        }

        $usuario->update($dados);

        // Cria registro de professor se mudou para professor e ainda não existe
        if ($request->role === 'professor' && !$usuario->professor) {
            Professor::create(['user_id' => $usuario->id, 'disciplina' => null]);
        }

        // Cria registro de aluno se mudou para aluno e ainda não existe
        if ($request->role === 'aluno' && !$usuario->aluno) {
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