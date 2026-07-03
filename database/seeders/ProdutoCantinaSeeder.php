<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProdutoCantina;
use App\Models\CategoriaCantina;

class ProdutoCantinaSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa na ordem certa por causa das FKs
        ProdutoCantina::truncate();
        CategoriaCantina::truncate();

        // ── Categorias ──
        $lanche = CategoriaCantina::create(['nome' => 'Lanche']);
        $bebida = CategoriaCantina::create(['nome' => 'Bebida']);

        // ── Produtos ──
        // As fotos ficam em public/img/cantina/
        // Referenciadas via asset('img/cantina/nome-do-arquivo')

        $produtos = [
            [
                'categoria_id'       => $lanche->id,
                'nome'               => 'Espetinho',
                'descricao'          => 'Espetinho de carne ou frango grelhado com farofa e vinagrete.',
                'preco'              => 8.00,
                'quantidade_estoque' => 30,
                'foto'               => 'img/cantina/espetinho.jpeg',
                'ativo'              => 1,
            ],
            [
                'categoria_id'       => $lanche->id,
                'nome'               => 'Mini Pizza',
                'descricao'          => 'Mini pizza assada — sabores: calabresa ou frango.',
                'preco'              => 7.00,
                'quantidade_estoque' => 25,
                'foto'               => 'img/cantina/mini-pizza.jpg',
                'ativo'              => 1,
            ],
            [
                'categoria_id'       => $lanche->id,
                'nome'               => 'Wrap de Frango',
                'descricao'          => 'Wrap recheado com frango desfiado ao molho.',
                'preco'              => 9.00,
                'quantidade_estoque' => 20,
                'foto'               => 'img/cantina/wrap-frango.png',
                'ativo'              => 1,
            ],
            [
                'categoria_id'       => $lanche->id,
                'nome'               => 'Hot-Dog',
                'descricao'          => 'Hot-dog clássico com salsicha, molhos e queijo ralado.',
                'preco'              => 8.50,
                'quantidade_estoque' => 25,
                'foto'               => 'img/cantina/hot-dog.jpeg',
                'ativo'              => 1,
            ],
            [
                'categoria_id'       => $lanche->id,
                'nome'               => 'Esfirra',
                'descricao'          => 'Esfirra de forno — carne, frango ou queijo.',
                'preco'              => 5.00,
                'quantidade_estoque' => 30,
                'foto'               => 'img/cantina/esfirra.jpg',
                'ativo'              => 1,
            ],
            [
                'categoria_id'       => $lanche->id,
                'nome'               => 'Pastel Frito',
                'descricao'          => 'Pastel frito crocante — carne ou queijo.',
                'preco'              => 6.00,
                'quantidade_estoque' => 20,
                'foto'               => 'img/cantina/pastel.jpeg',
                'ativo'              => 1,
            ],
            [
                'categoria_id'       => $bebida->id,
                'nome'               => 'Refrigerante',
                'descricao'          => 'Lata 350ml — Coca-Cola, Pepsi, Guaraná ou Fanta.',
                'preco'              => 5.00,
                'quantidade_estoque' => 50,
                'foto'               => 'img/cantina/refrigerante.jpg',
                'ativo'              => 1,
            ],
        ];

        foreach ($produtos as $p) {
            ProdutoCantina::create($p);
        }
    }
}