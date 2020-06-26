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
    return $this->belongsTo('App\Models\Empresas');
  }

  public function orcamento()
  {
    return $this->belongsTo('App\Models\Orcamentos');
  }

  protected $appends = ['tipoHumanized'];

  public function getTipoHumanizedAttribute()
  {
    return $this->_tipo[$this->tipo];
  }
}
