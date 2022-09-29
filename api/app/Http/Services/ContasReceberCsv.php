<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class ContasReceberCsv
{
    private $contasReceber;

    public function __construct($contasReceber)
    {
        $this->contasReceber = $contasReceber;
    }

    public function geraCsv()
    {
        $userId = Auth::id();

        // dd($this->contasPagar[0]->formaPagamento->forma_pagamento);
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
            'Código',
            'Vencimento',
            'Valor',
            'Pagamento',
            'Valor',
            'Orçamento',
            'Cliente',
            'Empresa',
            'Forma Pag.',
            'CT-e'
        ];
        fputcsv($h, $cabec, ',');
        foreach ($this->contasReceber as $rec) {
            $row = [
                $rec->id,
                implode('/', array_reverse(explode('-', $rec->data_vencimento))),
                $rec->valor,
                implode('/', array_reverse(explode('-', $rec->data_pagamento))),
                $rec->valor_pago,
                $rec->orcamento->id,
                $rec->orcamento->cliente->razao_social,
                $rec->empresa->razao_social,
                $rec->formaPagamento->forma_pagamento,
                '?'
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);

        return $arq;
    }
}