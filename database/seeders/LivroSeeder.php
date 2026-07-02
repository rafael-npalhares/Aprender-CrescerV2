<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;

class LivroSeeder extends Seeder
{
    public function run(): void
    {
        $livros = [
            ['titulo' => 'Dom Casmurro',                          'autor' => 'Machado de Assis',       'qtd_total' => 3, 'qtd_disponivel' => 3],
            ['titulo' => 'O Cortiço',                             'autor' => 'Aluísio Azevedo',        'qtd_total' => 2, 'qtd_disponivel' => 2],
            ['titulo' => 'Vidas Secas',                           'autor' => 'Graciliano Ramos',       'qtd_total' => 2, 'qtd_disponivel' => 2],
            ['titulo' => 'A Moreninha',                           'autor' => 'Joaquim Manuel de Macedo','qtd_total' => 1, 'qtd_disponivel' => 1],
            ['titulo' => 'O Guarani',                             'autor' => 'José de Alencar',        'qtd_total' => 2, 'qtd_disponivel' => 2],
            ['titulo' => 'Memórias Póstumas de Brás Cubas',      'autor' => 'Machado de Assis',       'qtd_total' => 3, 'qtd_disponivel' => 3],
            ['titulo' => 'Iracema',                               'autor' => 'José de Alencar',        'qtd_total' => 2, 'qtd_disponivel' => 2],
            ['titulo' => 'São Bernardo',                          'autor' => 'Graciliano Ramos',       'qtd_total' => 1, 'qtd_disponivel' => 1],
            ['titulo' => 'Fundamentos de Matemática Elementar',   'autor' => 'Gelson Iezzi',           'qtd_total' => 5, 'qtd_disponivel' => 5],
            ['titulo' => 'Biologia Moderna',                      'autor' => 'José Mariano Amabis',    'qtd_total' => 4, 'qtd_disponivel' => 4],
            ['titulo' => 'Física Conceitual',                     'autor' => 'Paul G. Hewitt',         'qtd_total' => 3, 'qtd_disponivel' => 3],
            ['titulo' => 'Gramática da Língua Portuguesa',        'autor' => 'Evanildo Bechara',       'qtd_total' => 2, 'qtd_disponivel' => 2],
            ['titulo' => 'História do Brasil',                    'autor' => 'Boris Fausto',           'qtd_total' => 2, 'qtd_disponivel' => 2],
            ['titulo' => 'O Pequeno Príncipe',                    'autor' => 'Antoine de Saint-Exupéry','qtd_total' => 4, 'qtd_disponivel' => 4],
            ['titulo' => 'Harry Potter e a Pedra Filosofal',      'autor' => 'J.K. Rowling',           'qtd_total' => 3, 'qtd_disponivel' => 3],
        ];

        foreach ($livros as $livro) {
            Livro::create($livro);
        }
    }
}
