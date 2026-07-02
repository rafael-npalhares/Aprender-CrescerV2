<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Um pedido representa o carrinho completo do usuário
        // Os produtos individuais ficam em itens_pedido_cantina
        Schema::create('pedidos_cantina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Sequencial global, nunca reinicia — exibido como #001, #002 na interface
            $table->unsignedInteger('numero_pedido')->unique();
            // Senha numérica de 4 dígitos gerada automaticamente no controller
            $table->string('senha_retirada', 4);
            // Data de retirada escolhida pelo usuário
            $table->date('data_retirada');
            $table->enum('status', ['pendente', 'entregue', 'cancelado'])->default('pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos_cantina');
    }
};
