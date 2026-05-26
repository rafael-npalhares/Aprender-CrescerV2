<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grade_horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turma_id')->constrained()->onDelete('cascade');
            $table->foreignId('professor_id')->constrained('users')->onDelete('cascade');
            $table->string('disciplina', 200);
            $table->enum('dia_semana', ['segunda', 'terca', 'quarta', 'quinta', 'sexta']);
            $table->enum('aula', ['1', '2', '3', '4', '5', '6']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_horarios');
    }
};
