<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AvisoController;
use App\Http\Controllers\Admin\GradeHorarioController;
use App\Http\Controllers\Admin\ReservaAdminController;
use App\Http\Controllers\Admin\TurmaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Aluno\AlunoController;
use App\Http\Controllers\Biblioteca\BibliotecaController;
use App\Http\Controllers\Cantina\CantinaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Professor\ProfessorController;
use App\Http\Controllers\Professor\ReservaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\Auth\ResetSenhaController;

Route::get('/esqueci-senha', [ResetSenhaController::class, 'formulario'])->name('esqueci.senha.form');
Route::post('/verificar-usuario', [ResetSenhaController::class, 'verificar'])->name('verificar.usuario');
Route::get('/nova-senha', [ResetSenhaController::class, 'novaSenhaForm'])->name('nova.senha.form');
Route::post('/salvar-nova-senha', [ResetSenhaController::class, 'salvar'])->name('salvar.nova.senha');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('/usuarios', UsuarioController::class);
        Route::resource('/turmas', TurmaController::class);
        Route::resource('/avisos', AvisoController::class);
        Route::resource('/grade', GradeHorarioController::class);

        Route::get('/reservas', [ReservaAdminController::class, 'index'])->name('reservas.index');
        Route::patch('/reservas/{reserva}/aprovar', [ReservaAdminController::class, 'aprovar'])->name('reservas.aprovar');
        Route::patch('/reservas/{reserva}/negar', [ReservaAdminController::class, 'negar'])->name('reservas.negar');
        Route::delete('/reservas/{reserva}', [ReservaAdminController::class, 'destroy'])->name('reservas.destroy');
        Route::get('/reservas/criar', [ReservaAdminController::class, 'create'])->name('reservas.create');
        Route::post('/reservas', [ReservaAdminController::class, 'store'])->name('reservas.store');

        Route::get('/biblioteca', [BibliotecaController::class, 'index'])->name('biblioteca.index');
        Route::get('/biblioteca/livros/criar', [BibliotecaController::class, 'createLivro'])->name('biblioteca.livros.create');
        Route::post('/biblioteca/livros', [BibliotecaController::class, 'storeLivro'])->name('biblioteca.livros.store');
        Route::get('/biblioteca/livros/{livro}/editar', [BibliotecaController::class, 'editLivro'])->name('biblioteca.livros.edit');
        Route::patch('/biblioteca/livros/{livro}', [BibliotecaController::class, 'updateLivro'])->name('biblioteca.livros.update');
        Route::delete('/biblioteca/livros/{livro}', [BibliotecaController::class, 'destroyLivro'])->name('biblioteca.livros.destroy');
        Route::get('/biblioteca/emprestimos', [BibliotecaController::class, 'emprestimos'])->name('biblioteca.emprestimos');
        
        Route::get('/cantina', [CantinaController::class, 'index'])->name('cantina.index');
        Route::get('/cantina/produtos/criar', [CantinaController::class, 'createProduto'])->name('cantina.produtos.create');
        Route::post('/cantina/produtos', [CantinaController::class, 'storeProduto'])->name('cantina.produtos.store');
        Route::get('/cantina/produtos/{produto}/editar', [CantinaController::class, 'editProduto'])->name('cantina.produtos.edit');
        Route::patch('/cantina/produtos/{produto}', [CantinaController::class, 'updateProduto'])->name('cantina.produtos.update');
        Route::delete('/cantina/produtos/{produto}', [CantinaController::class, 'destroyProduto'])->name('cantina.produtos.destroy');
        Route::get('/cantina/pedidos', [CantinaController::class, 'pedidos'])->name('cantina.pedidos');
        Route::patch('/cantina/pedidos/{pedido}/entregar', [CantinaController::class, 'entregar'])->name('cantina.pedidos.entregar');
        Route::patch('/cantina/pedidos/{pedido}/cancelar', [CantinaController::class, 'cancelar'])->name('cantina.pedidos.cancelar');
    });

Route::middleware(['auth', 'role:professor'])
    ->prefix('professor')
    ->name('professor.')
    ->group(function () {

        Route::get('/dashboard', [ProfessorController::class, 'index'])->name('dashboard');

        Route::get('/avisos', [ProfessorController::class, 'avisos'])->name('avisos');
        Route::get('/horarios', [ProfessorController::class, 'horarios'])->name('horarios');

        Route::resource('/reservas', ReservaController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        Route::get('/biblioteca', [BibliotecaController::class, 'index'])->name('biblioteca.index');
        Route::get('/biblioteca/buscar', [BibliotecaController::class, 'buscar'])->name('biblioteca.buscar');
        Route::post('/biblioteca/emprestimos', [BibliotecaController::class, 'emprestar'])->name('biblioteca.emprestar');
        Route::get('/biblioteca/meus-emprestimos', [BibliotecaController::class, 'meusEmprestimos'])->name('biblioteca.meus-emprestimos');
        Route::patch('/biblioteca/emprestimos/{emp}/renovar', [BibliotecaController::class, 'renovar'])->name('biblioteca.renovar');
        Route::patch('/biblioteca/emprestimos/{emp}/devolver', [BibliotecaController::class, 'devolver'])->name('biblioteca.devolver');

        Route::get('/cantina', [CantinaController::class, 'index'])->name('cantina.index');
        Route::post('/cantina/pedidos', [CantinaController::class, 'fazerPedido'])->name('cantina.pedidos.store');
        Route::get('/cantina/meus-pedidos', [CantinaController::class, 'meusPedidos'])->name('cantina.meus-pedidos');
        Route::patch('/cantina/pedidos/{pedido}/cancelar', [CantinaController::class, 'cancelar'])->name('cantina.pedidos.cancelar');
    });

Route::middleware(['auth', 'role:aluno'])
    ->prefix('aluno')
    ->name('aluno.')
    ->group(function () {

        Route::get('/dashboard', [AlunoController::class, 'index'])->name('dashboard');

        Route::get('/avisos', [AlunoController::class, 'avisos'])->name('avisos');
        Route::get('/horarios', [AlunoController::class, 'horarios'])->name('horarios');

        Route::get('/biblioteca', [BibliotecaController::class, 'index'])->name('biblioteca.index');
        Route::get('/biblioteca/buscar', [BibliotecaController::class, 'buscar'])->name('biblioteca.buscar');
        Route::post('/biblioteca/emprestimos', [BibliotecaController::class, 'emprestar'])->name('biblioteca.emprestar');
        Route::get('/biblioteca/meus-emprestimos', [BibliotecaController::class, 'meusEmprestimos'])->name('biblioteca.meus-emprestimos');
        Route::patch('/biblioteca/emprestimos/{emp}/renovar', [BibliotecaController::class, 'renovar'])->name('biblioteca.renovar');
        Route::patch('/biblioteca/emprestimos/{emp}/devolver', [BibliotecaController::class, 'devolver'])->name('biblioteca.devolver');

        Route::get('/cantina', [CantinaController::class, 'index'])->name('cantina.index');
        Route::post('/cantina/pedidos', [CantinaController::class, 'fazerPedido'])->name('cantina.pedidos.store');
        Route::get('/cantina/meus-pedidos', [CantinaController::class, 'meusPedidos'])->name('cantina.meus-pedidos');
        Route::patch('/cantina/pedidos/{pedido}/cancelar', [CantinaController::class, 'cancelar'])->name('cantina.pedidos.cancelar');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/biblioteca', [BibliotecaController::class, 'index'])
->name('biblioteca.index');

Route::get('/biblioteca/livros/criar', [BibliotecaController::class, 'createLivro'])
->name('admin.biblioteca.create');

Route::post('/biblioteca/livros', [BibliotecaController::class, 'storeLivro'])
->name('biblioteca.livros.store');

Route::get('/biblioteca/livros/{livro}/editar', [BibliotecaController::class, 'editLivro'])
->name('admin.biblioteca.edit');

Route::patch('/biblioteca/livros/{livro}', [BibliotecaController::class, 'updateLivro'])
->name('biblioteca.livros.update');

Route::delete('/biblioteca/livros/{livro}', [BibliotecaController::class, 'destroyLivro'])
->name('admin.biblioteca.destroy');

Route::get('/biblioteca/emprestimos', [BibliotecaController::class, 'emprestimos'])
->name('biblioteca.emprestimos');
