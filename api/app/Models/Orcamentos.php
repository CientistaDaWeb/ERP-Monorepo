<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Orcamentos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $_status;
    protected $_vantagens;

    function __construct(array $attributes = [])
    {
        $this->_status = [
            1 => 'Rascunho',
            2 => 'Aguardando Aprovação',
            3 => 'Aprovado',
            4 => 'Não Aprovado'
        ];
        $this->_vantagens = [
            'S' => 'Sim',
            'N' => 'Não'
        ];

        parent::__construct($attributes);
    }

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'usuario_id',
        'titulo',
        'condicoes_pagamento',
        'prazo_entrega',
        'observacoes',
        'data_emissao',
        'status',
        'valor_total',
        'vantagens'
    ];

    public $filters = [
        'id' =>
            [
                'column' => 'id',
                'type' => '='
            ]
    ];

    public function orcamentosServicos()
    {
        return $this->hasMany(OrcamentosServicos::class, 'orcamento_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresas::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }

    public function contasReceber()
    {
        return $this->hasMany(ContasReceber::class, 'orcamento_id', 'id');
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdensServico::class, 'orcamento_id', 'id');
    }

    public function ultimaOS()
    {
        return $this->hasOne(OrdensServico::class, 'orcamento_id', 'id')->orderBy('data_coleta', 'DESC');
    }

    public function ultimaOrdemServico()
    {
        return $this->hasMany(OrdensServico::class, 'orcamento_id', 'id')->orderBy('data_coleta', 'DESC')->first();
    }

    protected $appends = ['statusHumanized', 'vantagensHumanized', 'saldo', 'osCount', 'faturasCount'];

    public function getStatusHumanizedAttribute()
    {
        return $this->_status[$this->status];
    }

    public function getVantagensHumanizedAttribute()
    {
        return $this->_vantagens[$this->vantagens];
    }

    public function getSaldoAttribute()
    {
        return $this->contasReceber()->sum('valor') - $this->ordensServico()->sum('valor') - $this->ordensServico(
            )->sum('desconto');
    }

    public function getOsCountAttribute()
    {
        return $this->ordensServico()->count();
    }

    public function getFaturasCountAttribute()
    {
        return $this->contasReceber()->count();
    }

}
