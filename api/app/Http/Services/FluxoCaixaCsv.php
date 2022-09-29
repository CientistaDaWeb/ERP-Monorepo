<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class FluxoCaixaCsv
{
    private $fluxo;

    public function __construct($fluxo)
    {
        $this->fluxo = $fluxo;
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
            'Mês/Ano',
            'Recebido',
            'Pago',
            'Saldo'
        ];
        fputcsv($h, $cabec, ',');

        foreach ($this->fluxo['fluxo'] as $flx) {
            $row = [
                $flx['date'],
                $flx['Recebido'],
                $flx['Pago'],
                $flx['Saldo']
            ];
            fputcsv($h, $row, ',');
        }
        fputcsv($h, [], ',');

        fputcsv($h, ['Contas a Receber - Detalhamento por categoria'], ',');
        $cabec = [
            'Categoria de Cliente',
            '% do Recebido',
            'Recebido'
        ];
        fputcsv($h, $cabec, ',');
        $recebido = $this->fluxo['fluxoTotais']['Recebido'];
        foreach ($this->fluxo['detalhamentoContasReceber'] as $flx) {
            $row = [
                $flx['categoria'],
                $recebido == 0 ? 0 : $flx['total'] * 100 / $recebido,
                $flx['total']
            ];
            fputcsv($h, $row, ',');
        }
        fputcsv($h, [], ',');

        fputcsv($h, ['Contas a Pagar - Detalhamento por categoria'], ',');
        $cabec = [
            'Categoria de Conta',
            '% do Pago',
            'Pago'
        ];
        fputcsv($h, $cabec, ',');
        $pago = $this->fluxo['fluxoTotais']['Pago'];
        foreach ($this->fluxo['detalhamentoContasPagar'] as $flx) {
            $row = [
                $flx['categoria'],
                $pago == 0 ? 0 : $flx['total'] * 100 / $pago,
                $flx['total']
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);

        return $arq;
    }
}