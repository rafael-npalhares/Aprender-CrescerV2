<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Professor;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Aviso;
use App\Models\Sala;
use App\Models\Equipamento;
use App\Models\Reserva;
use App\Models\GradeHorario;
use App\Models\Livro;
use App\Models\Emprestimo;
use App\Models\ProdutoCantina;
use App\Models\PedidoCantina;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Desativa checagem de foreign keys para limpar as tabelas sem erro
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('pedidos_cantina')->truncate();
        DB::table('produtos_cantina')->truncate();
        DB::table('emprestimos')->truncate();
        DB::table('livros')->truncate();
        DB::table('grade_horarios')->truncate();
        DB::table('reservas')->truncate();
        DB::table('equipamentos')->truncate();
        DB::table('salas')->truncate();
        DB::table('avisos')->truncate();
        DB::table('alunos')->truncate();
        DB::table('professores')->truncate();
        DB::table('turmas')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ─── 1. USUÁRIOS ──────────────────────────────────────────────────────

        $admin = User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@aprendercrescer.com',
            'password' => '12345678',
            'role'     => 'admin',
        ]);

        $userProfessor = User::create([
            'name'     => 'Professor Teste',
            'email'    => 'professor@aprendercrescer.com',
            'password' => '12345678',
            'role'     => 'professor',
        ]);

        $userAluno = User::create([
            'name'     => 'Aluno Teste',
            'email'    => 'aluno@aprendercrescer.com',
            'password' => '12345678',
            'role'     => 'aluno',
        ]);

        // ─── 2. TURMA ─────────────────────────────────────────────────────────

        $turma = Turma::create([
            'serie'      => '1',
            'turma'      => 'A',
            'turno'      => 'manha',
            'ano_letivo' => 2026,
            'ativa'      => true,
        ]);

        // ─── 3. PROFESSOR e ALUNO (tabelas separadas) ─────────────────────────

        $professor = Professor::create([
            'user_id'    => $userProfessor->id,
            'disciplina' => 'Matemática',
        ]);

        $aluno = Aluno::create([
            'user_id'          => $userAluno->id,
            'turma_id'         => $turma->id,
            'matricula'        => '2026001',
            'data_nascimento'  => '2008-03-15',
        ]);

        // ─── 4. AVISOS ────────────────────────────────────────────────────────

        Aviso::create([
            'user_id'      => $admin->id,
            'titulo'       => 'Bem-vindos ao sistema!',
            'conteudo'     => 'O sistema Aprender & Crescer está no ar. Qualquer dúvida, entre em contato com a administração.',
            'visivel_para' => 'todos',
            'fixado'       => true,
            'ativo'        => true,
        ]);

        Aviso::create([
            'user_id'      => $admin->id,
            'titulo'       => 'Reunião de professores',
            'conteudo'     => 'Haverá reunião pedagógica na sexta-feira às 18h na sala dos professores.',
            'visivel_para' => 'professores',
            'fixado'       => false,
            'ativo'        => true,
        ]);

        Aviso::create([
            'user_id'      => $admin->id,
            'titulo'       => 'Entrega de trabalhos',
            'conteudo'     => 'O prazo final para entrega dos trabalhos do primeiro bimestre é dia 30/06.',
            'visivel_para' => 'alunos',
            'fixado'       => false,
            'ativo'        => true,
        ]);

        // ─── 5. SALAS ─────────────────────────────────────────────────────────

        $sala = Sala::create([
            'nome'       => 'Laboratório de Informática',
            'disponivel' => true,
        ]);

        Sala::create([
            'nome'       => 'Sala Multimidia',
            'disponivel' => true,
        ]);

        // ─── 6. EQUIPAMENTOS ──────────────────────────────────────────────────

        $equipamento = Equipamento::create([
            'nome'       => 'Projetor Epson',
            'descricao'  => 'Projetor para apresentações em sala de aula.',
            'disponivel' => true,
        ]);

        Equipamento::create([
            'nome'       => 'Notebook Dell',
            'descricao'  => 'Notebook para uso em aulas práticas.',
            'disponivel' => true,
        ]);

        // ─── 7. RESERVA ───────────────────────────────────────────────────────

        Reserva::create([
            'professor_id'   => $userProfessor->id,
            'sala_id'        => $sala->id,
            'equipamento_id' => $equipamento->id,
            'data'           => '2026-06-10',
            'horario_inicio' => '08:00:00',
            'horario_fim'    => '10:00:00',
            'finalidade'     => 'Aula prática de programação.',
            'status'         => 'pendente',
        ]);

        // ─── 8. GRADE DE HORÁRIOS ─────────────────────────────────────────────

        GradeHorario::create([
            'turma_id'     => $turma->id,
            'professor_id' => $userProfessor->id,
            'disciplina'   => 'Matemática',
            'dia_semana'   => 'segunda',
            'aula'         => '1',
        ]);

        GradeHorario::create([
            'turma_id'     => $turma->id,
            'professor_id' => $userProfessor->id,
            'disciplina'   => 'Matemática',
            'dia_semana'   => 'quarta',
            'aula'         => '2',
        ]);

        // ─── 9. LIVROS ────────────────────────────────────────────────────────

        $livro = Livro::create([
            'titulo'         => 'Algoritmos e Lógica de Programação',
            'autor'          => 'André Luiz Villar Forbellone',
            'qtd_total'      => 5,
            'qtd_disponivel' => 4,
        ]);

        Livro::create([
            'titulo'         => 'PHP e MySQL: Desenvolvimento Web',
            'autor'          => 'Luke Welling',
            'qtd_total'      => 3,
            'qtd_disponivel' => 3,
        ]);

        // ─── 10. EMPRÉSTIMO ───────────────────────────────────────────────────

        Emprestimo::create([
            'user_id'         => $userAluno->id,
            'livro_id'        => $livro->id,
            'data_emprestimo' => '2026-06-01',
            'data_devolucao'  => null,
            'renovacoes'      => 0,
            'status'          => 'ativo',
        ]);

        // ─── 11. PRODUTOS CANTINA ─────────────────────────────────────────────

        $produto = ProdutoCantina::create([
            'nome'               => 'Salgado de Frango',
            'preco'              => 4.50,
            'quantidade_estoque' => 20,
            'ativo'              => true,
        ]);

        ProdutoCantina::create([
            'nome'               => 'Suco de Laranja',
            'preco'              => 3.00,
            'quantidade_estoque' => 15,
            'ativo'              => true,
        ]);

        ProdutoCantina::create([
            'nome'               => 'Água Mineral 500ml',
            'preco'              => 2.00,
            'quantidade_estoque' => 30,
            'ativo'              => true,
        ]);

        // ─── 12. PEDIDO CANTINA ───────────────────────────────────────────────

        PedidoCantina::create([
            'user_id'    => $userAluno->id,
            'produto_id' => $produto->id,
            'quantidade' => 2,
            'status'     => 'pendente',
        ]);
    }
}