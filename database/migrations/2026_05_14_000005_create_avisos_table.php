<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo', 200);
            $table->text('conteudo');
            $table->enum('visivel_para', ['todos', 'alunos', 'professores'])->default('todos');
            // data_expiracao REMOVIDA — não será utilizada
            // fixado funciona como toggle (admin pode fixar e desfixar)
            $table->boolean('fixado')->default(false);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
