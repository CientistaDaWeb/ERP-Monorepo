<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrdensServico extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $table = 'ordens_servico';

    protected $fillable = [
        'orcamento_id',
        'empresa_id',
        'transportador_id',
        'endereco_id',
        'data_coleta',
        'hora_coleta',
        'numero_coletas',
        'status',
        'valor',
        'sequencial',
        'desconto',
        'observacoes',
        'ordem_compra',
        'tipo_reservatorio',
        'acesso',
        'metragem_mangueira',
        'situacao_tampas',
        'situacao_efluentes',
        'observacoes_poscoleta',
        'horas_trabalhadas',
        'checagem_final',
        'faturado',
        'observacoes_faturamento'
    ];

    public $filters = [
        /*
        'empresa' => [
          'column' => 'empresa.razao_social',
          'type' => 'like'
        ]
        */
    ];

    public $status = array(
        1 => 'Aguardando',
        2 => 'Executando',
        3 => 'Concluido',
        4 => 'Cancelada',
        5 => 'Cortesia'
    );

    public $tipo_reservatorio = array(
        'F' => 'FOSSA',
        'I' => 'FILTRO',
        'FF' => 'FOSSA/FILTRO',
        'T' => 'TANQUE',
        'B' => 'BOMBONA',
        'O' => 'OUTROS'
    );

    public $acesso = array(
        'D' => 'DIFÍCIL',
        'R' => 'REGULAR',
        'F' => 'FÁCIL'
    );

    public $situacao_efluentes = array(
        'N' => 'RESÍDUO NORMAL',
        'M' => 'RESÍDUO COM MISTURAS',
        'A' => 'RESÍDUO ALTERADO'
    );

    public $checagem_final = array(
        'L' => 'LACRE DA FOSSA',
        'LL' => 'LIMPEZA DO LOCAL',
        'M' => 'MTR',
        'F' => 'FICHA DE EMERGÊNCIA',
        'E' => "EPI's",
        'P' => 'PLACAS',
    );

    public $faturado = array(
        'N' => 'Não',
        'S' => 'Sim',
    );

    public function empresa()
    {
        return $this->belongsTo(Empresas::class);
    }

    public function endereco()
    {
        return $this->belongsTo(ClientesEnderecos::class, 'endereco_id', 'id');
    }

    public function orcamento()
    {
        return $this->belongsTo(Orcamentos::class, 'orcamento_id', 'id');
    }

    public function transportador()
    {
        return $this->belongsTo('App\Models\Transportadores');
    }

    public function mtrs()
    {
        return $this->hasMany(Mtrs::class, 'ordem_servico_id');
    }


    protected $appends = ['codigo', 'volumes', 'certificado'];

    public function getCodigoAttribute()
    {
        return $this->orcamento['id'] . '.' . $this->sequencial;
    }

    public function getVolumesAttribute()
    {
        return [
            'domestico' => rand(0, 10),
            'industrial' => rand(0, 10),
            'transporte' => rand(0, 10)
        ];
    }

    public function getCertificadoAttribute()
    {
        $options = [0 => 'Sim', '1' => 'Não'];
        return $options[rand(0, 1)];
    }

}
