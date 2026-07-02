<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Deve rodar ANTES de produtos_cantina pois produtos referenciam categorias
        Schema::create('categorias_cantina', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100); // Ex: Lanche, Bebida, Sobremesa, Salgado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_cantina');
    }
};
