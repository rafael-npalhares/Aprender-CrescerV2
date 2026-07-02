<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamento;

class EquipamentoSeeder extends Seeder
{
    public function run(): void
    {
        $equipamentos = [
            ['nome' => 'Projetor Epson X01',         'descricao' => 'Projetor multimídia 3200 lumens, HDMI e VGA.'],
            ['nome' => 'Projetor Epson X02',         'descricao' => 'Projetor multimídia 3200 lumens, HDMI e VGA.'],
            ['nome' => 'Notebook Dell 01',            'descricao' => 'Notebook para uso em sala, i5 8GB RAM.'],
            ['nome' => 'Notebook Dell 02',            'descricao' => 'Notebook para uso em sala, i5 8GB RAM.'],
            ['nome' => 'Caixa de Som Bluetooth',      'descricao' => 'Caixa de som portátil para apresentações.'],
            ['nome' => 'Câmera Filmadora',            'descricao' => 'Câmera para gravação de aulas e eventos.'],
            ['nome' => 'Microfone sem fio',           'descricao' => 'Microfone de lapela sem fio para apresentações.'],
            ['nome' => 'Lousa Digital Interativa',    'descricao' => 'Lousa interativa 65" instalada no auditório.'],
            ['nome' => 'Extensão Elétrica 10m',       'descricao' => 'Extensão elétrica para uso em eventos externos.'],
        ];

        foreach ($equipamentos as $eq) {
            Equipamento::create([
                'nome'       => $eq['nome'],
                'descricao'  => $eq['descricao'],
                'disponivel' => true,
            ]);
        }
    }
}
