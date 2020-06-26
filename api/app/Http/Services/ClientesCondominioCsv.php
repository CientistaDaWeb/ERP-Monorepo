<?php

namespace App\Http\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class ClientesCondominioCsv
{
    private $cliCond;

    public function __construct($cliCond)
    {
        $this->cliCond = $cliCond;
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
            'Cliente',
            'Telefones',
            'Endereço'
        ];
        fputcsv($h, $cabec, ',');

        foreach ($this->cliCond as $cli) {
            $telefones = $this->pegaTelefones($cli->telefones);
            $row = [
                $cli->id,
                $cli->razao_social,
                $telefones,
                count($cli->enderecos) > 0
                    ? $cli->enderecos[0]->endereco . ',' .$cli->enderecos[0]->numero . ' ' .
                        $cli->enderecos[0]->complemento . ' - ' . $cli->enderecos[0]->bairro . ' - ' .
                        $cli->enderecos[0]->estado->uf
                    : ''
            ];
            fputcsv($h, $row, ',');
        }

        fclose($h);

        return $arq;
    }

    private function pegaTelefones($telefones)
    {
        $tels = '';
        foreach ($telefones as $telefone) {
            $tels .= $telefone->telefone . ', ';
        }

        return substr($tels, 0, strlen($tels) - 2);
    }
}