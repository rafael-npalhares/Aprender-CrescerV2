<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('turma_id')->nullable()->constrained()->onDelete('set null');
            // Gerada automaticamente no Model Aluno via boot()
            // Formato: AP + ano_atual + sequencial com 4 dígitos → AP20260001
            $table->string('matricula', 20)->unique();
            $table->date('data_nascimento')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
