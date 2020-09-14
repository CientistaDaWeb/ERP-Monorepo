<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class NotasFiscais extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'orcamento_id',
        'empresa_id',
        'data_geracao',
        'valor',
        'numero',
        'tipo',
        'valor_retido'
    ];

    public $filters = [
        'numero' =>
            [
                'column' => 'numero',
                'type' => 'like'
            ],
    ];

    protected $_tipo;

    public function __construct(array $attributes = [])
    {
        $this->_tipo = array(
            'S' => 'Serviços',
            'P' => 'Projetos'
        );

        parent::__construct($attributes);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresas::class);
    }

    public function orcamento()
    {
        return $this->belongsTo(Orcamentos::class);
    }

    protected $appends = ['tipoHumanized'];

    public function getTipoHumanizedAttribute()
    {
        return $this->_tipo[$this->tipo];
    }
}
