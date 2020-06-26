<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Contratos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'orcamento_id',
    'data_assinatura',
    'data_encerramento',
    'servico_contratado',
    'tipo_efluente',
    'condicoes',
    'valor_transporte',
    'valor_tratamento',
    'acabado'
  ];

  public $filters = [
    'data_assinatura' =>
      [
        'column' => 'data_assinatura',
        'type' => 'date'
      ],
    'condicoes' =>
      [
        'column' => 'condicoes',
        'type' => 'like'
      ],
  ];

  public function orcamento()
  {
    return $this->belongsTo('App\Models\Orcamentos');
  }
}
