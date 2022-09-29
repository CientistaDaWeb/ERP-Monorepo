<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class OrcamentosCsv
{
    private $orcamentos;

    public function __construct($orcamentos)
    {
        $this->orcamentos = $orcamentos;
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

        /* CRIA NOME DO .PDF */
        $faker = Faker::create();
        $arq = $userId . '_' . $faker->uuid;

        $status = [
            '',
            'Rascunho',
            'Aguardando Aprovação',
            'Aprovado',
            'Não Aprovado'
        ];

        $h = fopen($arq . '.csv', 'w+');

        $cabec = [
            'Status',
            'Data',
            'Código',
            'Cliente',
            'Empresa',
            'Funcionário',
            'No OS',
            'No Fat',
            'Saldo'
        ];
        fputcsv($h, $cabec, ',');
        foreach ($this->orcamentos as $orc) {
            $row = [
                $status[$orc->status],
                implode('/', array_reverse(explode('-', $orc->data_emissao))),
                $orc->id,
                $orc->cliente->razao_social,
                $orc->empresa->razao_social,
                $orc->usuario->nome,
                $orc->osCount,
                $orc->faturasCount,
                $orc->saldo
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);
        return $arq;
    }
}