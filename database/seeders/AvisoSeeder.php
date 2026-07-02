<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aviso;
use App\Models\User;

class AvisoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $avisos = [
            [
                'titulo'      => 'Bem-vindos ao Aprender & Crescer!',
                'conteudo'    => 'É com grande satisfação que damos as boas-vindas a todos os alunos, professores e colaboradores no novo sistema escolar. Navegue pelos módulos disponíveis e explore as funcionalidades.',
                'visivel_para' => 'todos',
                'fixado'      => true,
                'ativo'       => true,
            ],
            [
                'titulo'      => 'Reunião de Pais e Mestres — Junho',
                'conteudo'    => 'A reunião de pais e mestres do 1º semestre será realizada no dia 28/06/2026 a partir das 09h no auditório principal. A presença é fundamental.',
                'visivel_para' => 'todos',
                'fixado'      => false,
                'ativo'       => true,
            ],
            [
                'titulo'      => 'Prazo para entrega de notas — 1º Bimestre',
                'conteudo'    => 'Lembramos que o prazo final para lançamento de notas do 1º bimestre é 30/06/2026. Professores que não realizarem o lançamento até esta data deverão justificar à coordenação.',
                'visivel_para' => 'professores',
                'fixado'      => false,
                'ativo'       => true,
            ],
            [
                'titulo'      => 'Calendário de Provas — 1º Bimestre',
                'conteudo'    => 'O calendário de provas do 1º bimestre já está disponível no módulo de horários. Consulte as datas e prepare-se com antecedência.',
                'visivel_para' => 'alunos',
                'fixado'      => false,
                'ativo'       => true,
            ],
            [
                'titulo'      => 'Manutenção do sistema — 25/06/2026',
                'conteudo'    => 'O sistema ficará em manutenção no dia 25/06/2026 das 22h às 23h. Durante este período o acesso estará temporariamente indisponível.',
                'visivel_para' => 'todos',
                'fixado'      => false,
                'ativo'       => true,
            ],
        ];

        foreach ($avisos as $aviso) {
            Aviso::create([
                'user_id'      => $admin->id,
                'titulo'       => $aviso['titulo'],
                'conteudo'     => $aviso['conteudo'],
                'visivel_para' => $aviso['visivel_para'],
                'fixado'       => $aviso['fixado'],
                'ativo'        => $aviso['ativo'],
            ]);
        }
    }
}
