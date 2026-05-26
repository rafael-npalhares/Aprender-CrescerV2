<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produtos_cantina', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 200);
            $table->decimal('preco', 8, 2);
            $table->integer('quantidade_estoque')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos_cantina');
    }
};
