<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AvisoController;
use App\Http\Controllers\Admin\GradeHorarioController;
use App\Http\Controllers\Admin\ReservaAdminController;
use App\Http\Controllers\Admin\TurmaController;
use App\Http\Controllers\Admin\UsuarioController;
// Aluno
use App\Http\Controllers\Aluno\AlunoController;
// Biblioteca
use App\Http\Controllers\Biblioteca\BibliotecaController;
// Cantina
use App\Http\Controllers\Cantina\CantinaController;
use App\Http\Controllers\Cantina\GerenteController;
// Professor
use App\Http\Controllers\Professor\ProfessorController;
use App\Http\Controllers\Professor\ReservaController;
//
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// ─────────────────────────────────────────────────────────────────────────────
// ADMIN
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Usuários
    Route::resource('/usuarios', UsuarioController::class);

    // Turmas
    Route::resource('/turmas', TurmaController::class);

    // Avisos
    Route::resource('/avisos', AvisoController::class);
    Route::patch('/avisos/{aviso}/toggle-fixado', [AvisoController::class, 'toggleFixado'])->name('avisos.toggleFixado');
    Route::patch('/avisos/{aviso}/toggle-ativo',  [AvisoController::class, 'toggleAtivo']) ->name('avisos.toggleAtivo');

    // Grade de horários
    Route::resource('/grade', GradeHorarioController::class);

    // Reservas
    Route::get('/reservas',                           [ReservaAdminController::class, 'index'])  ->name('reservas.index');
    Route::get('/reservas/criar',                     [ReservaAdminController::class, 'create']) ->name('reservas.create');
    Route::post('/reservas',                          [ReservaAdminController::class, 'store'])  ->name('reservas.store');
    Route::patch('/reservas/{reserva}/aprovar',       [ReservaAdminController::class, 'aprovar'])->name('reservas.aprovar');
    Route::patch('/reservas/{reserva}/negar',         [ReservaAdminController::class, 'negar'])  ->name('reservas.negar');
    Route::delete('/reservas/{reserva}',              [ReservaAdminController::class, 'destroy'])->name('reservas.destroy');

    // Biblioteca (gestão admin)
    Route::get('/biblioteca',                              [BibliotecaController::class, 'index'])       ->name('biblioteca.index');
    Route::get('/biblioteca/livros/criar',                 [BibliotecaController::class, 'createLivro']) ->name('biblioteca.livros.create');
    Route::post('/biblioteca/livros',                      [BibliotecaController::class, 'storeLivro'])  ->name('biblioteca.livros.store');
    Route::get('/biblioteca/livros/{livro}/editar',        [BibliotecaController::class, 'editLivro'])   ->name('biblioteca.livros.edit');
    Route::patch('/biblioteca/livros/{livro}',             [BibliotecaController::class, 'updateLivro']) ->name('biblioteca.livros.update');
    Route::delete('/biblioteca/livros/{livro}',            [BibliotecaController::class, 'destroyLivro'])->name('biblioteca.livros.destroy');
    Route::get('/biblioteca/emprestimos',                  [BibliotecaController::class, 'emprestimos']) ->name('biblioteca.emprestimos');
    Route::patch('/biblioteca/emprestimos/{emp}/devolver', [BibliotecaController::class, 'devolver'])    ->name('biblioteca.devolver');
    Route::patch('/biblioteca/emprestimos/{emp}/atraso',   [BibliotecaController::class, 'marcarAtraso'])->name('biblioteca.atraso');

    // Cantina (gestão admin: CRUD de produtos + visualizar/cancelar/deletar pedidos)
    Route::get('/cantina',                           [CantinaController::class, 'adminIndex'])    ->name('cantina.index');
    Route::get('/cantina/produtos/criar',            [CantinaController::class, 'createProduto']) ->name('cantina.produtos.create');
    Route::post('/cantina/produtos',                 [CantinaController::class, 'storeProduto'])  ->name('cantina.produtos.store');
    Route::get('/cantina/produtos/{produto}/editar', [CantinaController::class, 'editProduto'])   ->name('cantina.produtos.edit');
    Route::patch('/cantina/produtos/{produto}',      [CantinaController::class, 'updateProduto']) ->name('cantina.produtos.update');
    Route::delete('/cantina/produtos/{produto}', [CantinaController::class, 'excluirProduto'])
    ->name('cantina.produtos.destroy');
    Route::get('/cantina/pedidos',                   [CantinaController::class, 'pedidos'])       ->name('cantina.pedidos');
    Route::patch('/cantina/pedidos/{pedido}/cancelar',[CantinaController::class, 'cancelar'])     ->name('cantina.pedidos.cancelar');
    Route::delete('/cantina/pedidos/{pedido}',        [CantinaController::class, 'destroy'])      ->name('cantina.pedidos.destroy');
    Route::patch('cantina/produtos/{produto}/ativar', [CantinaController::class, 'ativarProduto'])
    ->name('cantina.produtos.ativar');
    Route::patch('/cantina/produtos/{produto}/desativar', [CantinaController::class, 'desativarProduto'])
    ->name('cantina.produtos.desativar');
    
    Route::post('/cantina/categorias',              [CantinaController::class, 'storeCategoria'])  ->name('cantina.categorias.store');
    Route::patch('/cantina/categorias/{categoria}', [CantinaController::class, 'updateCategoria']) ->name('cantina.categorias.update');
    Route::delete('/cantina/categorias/{categoria}',[CantinaController::class, 'destroyCategoria'])->name('cantina.categorias.destroy');
});

// ─────────────────────────────────────────────────────────────────────────────
// PROFESSOR
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:professor'])->prefix('professor')->name('professor.')->group(function () {

    Route::get('/dashboard', [ProfessorController::class, 'index'])->name('dashboard');
    Route::get('/avisos',    [ProfessorController::class, 'avisos'])->name('avisos');
    Route::get('/horarios',  [ProfessorController::class, 'horarios'])->name('horarios');

    Route::resource('/reservas', ReservaController::class)
        ->only(['index', 'create', 'store', 'destroy']);
});

// ─────────────────────────────────────────────────────────────────────────────
// ALUNO
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:aluno'])->prefix('aluno')->name('aluno.')->group(function () {

    Route::get('/dashboard', [AlunoController::class, 'index'])->name('dashboard');
    Route::get('/avisos',    [AlunoController::class, 'avisos'])->name('avisos');
    Route::get('/horarios',  [AlunoController::class, 'horarios'])->name('horarios');
});

// ─────────────────────────────────────────────────────────────────────────────
// COMPARTILHADAS (aluno + professor — protegidas apenas por auth)
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Biblioteca
    Route::get('/biblioteca',                             [BibliotecaController::class, 'index'])          ->name('biblioteca.index');
    Route::get('/biblioteca/buscar',                      [BibliotecaController::class, 'buscar'])         ->name('biblioteca.buscar');
    Route::get('/biblioteca/livros/{livro}',              [BibliotecaController::class, 'showLivro'])      ->name('biblioteca.livros.show');
    Route::post('/biblioteca/emprestimos',                [BibliotecaController::class, 'emprestar'])      ->name('biblioteca.emprestar');
    Route::get('/biblioteca/meus-emprestimos',            [BibliotecaController::class, 'meusEmprestimos'])->name('biblioteca.meus-emprestimos');
    Route::patch('/biblioteca/emprestimos/{emp}/renovar', [BibliotecaController::class, 'renovar'])        ->name('biblioteca.renovar');

    // Cantina
    Route::get('/cantina',                              [CantinaController::class, 'index'])       ->name('cantina.index');
    Route::post('/cantina/pedidos',                     [CantinaController::class, 'fazerPedido']) ->name('cantina.pedidos.store');
    Route::patch('/cantina/pedidos/{pedido}/cancelar',  [CantinaController::class, 'cancelar'])   ->name('cantina.pedidos.cancelar');
    Route::get('/cantina/meus-pedidos',                 [CantinaController::class, 'meusPedidos'])->name('cantina.meus-pedidos');

    // Perfil (Breeze)
    Route::get('/profile',    [ProfileController::class, 'edit'])   ->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update']) ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─────────────────────────────────────────────────────────────────────────────
// GERENTE (acesso exclusivo à cantina)
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:gerente'])->prefix('gerente')->name('gerente.')->group(function () {
    Route::get('/dashboard',                    [GerenteController::class, 'index'])    ->name('dashboard');
    Route::get('/pedidos',                      [GerenteController::class, 'pedidos'])  ->name('pedidos.index');
    Route::get('/pedidos/{pedido}',             [GerenteController::class, 'show'])     ->name('pedidos.show');
    Route::patch('/pedidos/{pedido}/entregar',  [GerenteController::class, 'entregar']) ->name('pedidos.entregar');
    Route::patch('/pedidos/{pedido}/cancelar',  [GerenteController::class, 'cancelar']) ->name('pedidos.cancelar');
});

require __DIR__ . '/auth.php';