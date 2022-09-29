<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class ContasPagarCsv
{
    private $contasPagar;

    public function __construct($contasPagar)
    {
        $this->contasPagar = $contasPagar;
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
            'Cat. Forn.',
            'Fornecedor',
            'Cat. Conta',
            'Empresa',
            'Forma Pgto'
        ];
        fputcsv($h, $cabec, ',');
        foreach ($this->contasPagar as $pag) {
            $row = [
                $pag->id,
                implode('/', array_reverse(explode('-', $pag->data_vencimento))),
                $pag->valor,
                implode('/', array_reverse(explode('-', $pag->data_pagamento))),
                $pag->valor_pago,
                $pag->fornecedor->categoria->categoria,
                $pag->fornecedor->razao_social,
                $pag->categoria->categoria,
                $pag->empresa->razao_social,
                $pag->formaPagamento->forma_pagamento
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);

        return $arq;
    }
}