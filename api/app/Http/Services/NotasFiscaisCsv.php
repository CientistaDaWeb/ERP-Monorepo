<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class NotasFiscaisCsv
{
    private $notas;

    public function __construct($notas)
    {
        $this->notas = $notas;
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

        $h = fopen($arq . '.csv', 'w+');

        $cabec = [
            '#',
            'Número',
            'Cliente',
            'Orçamento',
            'Data de Emissão',
            'Tipo',
            'Valor',
            'Valor Retido'
        ];
        fputcsv($h, $cabec, ',');

        $tipos = [
            'S' => 'Serviços',
            'P' => 'Projetos'
        ];
        $id = 1;
        foreach ($this->notas as $nota) {
            $row = [
                $id++,
                $nota->numero,
                $nota->orcamento->cliente->razao_social,
                $nota->orcamento->id,
                implode('/', array_reverse(explode('-', $nota->data_geracao))),
                $tipos[$nota->tipo],
                $nota->valor,
                $nota->valor_retido
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);

        return $arq;
    }
}