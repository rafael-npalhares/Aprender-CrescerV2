<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
//Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AvisoController;
use App\Http\Controllers\Admin\GradeHorarioController;
use App\Http\Controllers\Admin\ReservaAdminController;
use App\Http\Controllers\Admin\TurmaController;
use App\Http\Controllers\Admin\UsuarioController;
//Aluno
use App\Http\Controllers\Aluno\AlunoController;
//Biblioteca
use App\Http\Controllers\Biblioteca\BibliotecaController;
//cantina
use App\Http\Controllers\Cantina\CantinaController;
//professor
use App\Http\Controllers\Professor\ProfessorController;
use App\Http\Controllers\Professor\ReservaController;
//
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

//Rotas de admin 
Route::middleware(['auth', 'role:admin']) ->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('turmas', TurmaController::class);
});

//Rotas de professor  
Route::middleware(['auth', 'role:professor']) ->prefix('professor')->name('professor.')->group(function(){
    Route::get('/dashboard', [ProfessorController::class, 'index']) -> name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
