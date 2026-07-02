<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produtos_cantina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias_cantina')->onDelete('restrict');
            $table->string('nome', 200);
            $table->string('descricao', 300)->nullable();
            // Caminho salvo em storage/app/public/cantina/
            $table->string('foto')->nullable();
            $table->decimal('preco', 8, 2);
            $table->integer('quantidade_estoque')->default(0);
            // Quando estoque = 0, produto aparece como "esgotado" no cardápio
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos_cantina');
    }
};
