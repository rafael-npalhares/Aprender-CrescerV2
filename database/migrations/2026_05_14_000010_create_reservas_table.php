<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sala_id')->nullable()->constrained('salas')->onDelete('set null');
            $table->foreignId('equipamento_id')->nullable()->constrained('equipamentos')->onDelete('set null');
            $table->date('data');
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->text('finalidade')->nullable();
            $table->enum('status', ['pendente', 'aprovada', 'negada'])->default('pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
