<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class OrdemServicoCsv
{
    private $os;

    public function __construct($os)
    {
        $this->os = $os;
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
            'Status',
            'Código',
            'Data da Coleta',
            'Cliente',
            'Empresa',
            'Vol. Dom.',
            'Vol Ind.',
            'Transporte',
            'Cert.'
        ];
        fputcsv($h, $cabec, ',');

        $status = [
            '',
            'Aguardando',
            'Executando',
            'Concluido',
            'Cancelada',
            'Cortesia'
        ];
        foreach ($this->os as $os) {
            $os = $os->toArray();
            $row = [
                $status[$os['status']],
                $os['codigo'],
                implode('/', array_reverse(explode('-', $os['data_coleta']))),
                $os['orcamento']['cliente']['razao_social'],
                $os['empresa']['razao_social'],
                $os['volumes']['domestico'],
                $os['volumes']['industrial'],
                $os['volumes']['transporte'],
                $os['certificado']
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);

        return $arq;
    }
}