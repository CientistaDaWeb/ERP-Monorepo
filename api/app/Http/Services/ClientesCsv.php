<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class ClientesCsv
{
    private $clientes;

    public function __construct($clientes)
    {
        $this->clientes = $clientes;
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
            'Código',
            'Cliente',
            'Último Orçamento',
            'Última Ordem de Serviço',
            'Administrador de Condomínio'
        ];
        fputcsv($h, $cabec, ',');

        $id = 1;
        foreach ($this->clientes as $cliente) {
            $ulOrc = $cliente->ultimoOrcamento ? $cliente->ultimoOrcamento->data_emissao : null;
            $ulOrc = $ulOrc ? implode('/', array_reverse(explode('-', $ulOrc))): '';
            $os = ($cliente->ultimoOrcamento != null &&
                $cliente->ultimoOrcamento->ultimaOS != null) ?
                $cliente->ultimoOrcamento->ultimaOS->data_coleta : null;
            $os = $os
                ? implode('/', array_reverse(explode('-', $os)))
                : '';
            $row = [
                $id++,
                $cliente->id,
                $cliente->razao_social,
                $ulOrc,
                $os,
                $cliente->administrador ? $cliente->administrador->nome : ''
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);

        return $arq;
    }
}