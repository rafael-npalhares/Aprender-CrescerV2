<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProdutoCantina;
use App\Models\CategoriaCantina;

class ProdutoCantinaSeeder extends Seeder
{
    public function run(): void
    {
        $lanche    = CategoriaCantina::where('nome', 'Lanche')->first();
        $refeicao  = CategoriaCantina::where('nome', 'Refeição')->first();
        $bebida    = CategoriaCantina::where('nome', 'Bebida')->first();
        $sobremesa = CategoriaCantina::where('nome', 'Sobremesa')->first();
        $salgado   = CategoriaCantina::where('nome', 'Salgado')->first();
        $fruta     = CategoriaCantina::where('nome', 'Fruta')->first();

        $produtos = [
            // Lanches
            ['categoria' => $lanche,    'nome' => 'Pão de Queijo',        'descricao' => 'Pão de queijo quentinho, 3 unidades.',   'preco' => 5.00,  'estoque' => 30],
            ['categoria' => $lanche,    'nome' => 'Misto Quente',         'descricao' => 'Sanduíche de presunto e queijo grelhado.','preco' => 8.50,  'estoque' => 20],
            ['categoria' => $lanche,    'nome' => 'Cachorro-Quente',      'descricao' => 'Salsicha, molho e batata palha.',          'preco' => 9.00,  'estoque' => 15],
            // Refeições
            ['categoria' => $refeicao,  'nome' => 'Marmita Completa',     'descricao' => 'Arroz, feijão, carne e salada.',          'preco' => 18.00, 'estoque' => 25],
            ['categoria' => $refeicao,  'nome' => 'Macarrão ao Molho',    'descricao' => 'Macarrão parafuso ao molho vermelho.',    'preco' => 14.00, 'estoque' => 20],
            // Bebidas
            ['categoria' => $bebida,    'nome' => 'Suco de Laranja',      'descricao' => 'Suco natural 300ml.',                    'preco' => 6.00,  'estoque' => 40],
            ['categoria' => $bebida,    'nome' => 'Refrigerante Lata',    'descricao' => 'Lata 350ml (Coca, Guaraná ou Sprite).',  'preco' => 5.00,  'estoque' => 50],
            ['categoria' => $bebida,    'nome' => 'Água Mineral',         'descricao' => 'Garrafa 500ml.',                         'preco' => 3.00,  'estoque' => 60],
            ['categoria' => $bebida,    'nome' => 'Achocolatado',         'descricao' => 'Caixinha 200ml.',                        'preco' => 4.00,  'estoque' => 35],
            // Sobremesas
            ['categoria' => $sobremesa, 'nome' => 'Bolo de Chocolate',    'descricao' => 'Fatia de bolo de chocolate com cobertura.','preco' => 7.00, 'estoque' => 20],
            ['categoria' => $sobremesa, 'nome' => 'Pudim',                'descricao' => 'Porção individual de pudim de leite.',   'preco' => 6.50,  'estoque' => 15],
            // Salgados
            ['categoria' => $salgado,   'nome' => 'Coxinha',              'descricao' => 'Coxinha de frango 120g.',                'preco' => 5.50,  'estoque' => 25],
            ['categoria' => $salgado,   'nome' => 'Esfiha',               'descricao' => 'Esfiha de carne ou queijo.',             'preco' => 4.50,  'estoque' => 30],
            // Frutas
            ['categoria' => $fruta,     'nome' => 'Banana',               'descricao' => 'Banana prata unidade.',                  'preco' => 2.00,  'estoque' => 0],  // esgotado de exemplo
            ['categoria' => $fruta,     'nome' => 'Maçã',                 'descricao' => 'Maçã Fuji unidade.',                     'preco' => 2.50,  'estoque' => 20],
        ];

        foreach ($produtos as $p) {
            ProdutoCantina::create([
                'categoria_id'      => $p['categoria']?->id,
                'nome'              => $p['nome'],
                'descricao'         => $p['descricao'],
                'foto'              => null, // fotos adicionadas pelo admin via painel
                'preco'             => $p['preco'],
                'quantidade_estoque'=> $p['estoque'],
                'ativo'             => true,
            ]);
        }
    }
}
