<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class AtendimentosCsv
{
    private $atendimentos;

    public function __construct($atendimentos)
    {
        $this->atendimentos = $atendimentos;
    }

    public function geraCsv()
    {
        $userId = Auth::id();

        /* REMOVE ARQUIVOS .CSV ANTIGOS DO USUÁRIO */
        $aArqs = array_slice(scandir($_SERVER['DOCUMENT_ROOT']), 2);
        foreach ($aArqs as $arq) {
            if (preg_match('/' . $userId . '_.*\.csv/', $arq)) {
                unlink($arq);
            }
        }

        /* CRIA NOME DO .CSV */
        $faker = Faker::create();
        $arq = $userId . '_' . $faker->uuid;

        $status = [
            'R' => 'Resolvido',
            'A' => 'Aguardando'
        ];

        $h = fopen($arq . '.csv', 'w+');

        $cabec = [
            'Status',
            'Código',
            'Data',
            'Cliente',
            'Descrição',
            'Funcionário'
        ];
        fputcsv($h, $cabec, ',');
        foreach ($this->atendimentos as $atd) {
            $row = [
                $status[$atd->status],
                $atd->id,
                implode('/', array_reverse(explode('-', $atd->data))),
                $atd->cliente->razao_social,
                $atd->descricao,
                $atd->usuario->nome
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);
        return $arq;
    }
}