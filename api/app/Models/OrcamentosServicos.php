<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrcamentosServicos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'orcamento_id',
    'servico_id',
    'qtde',
    'preco'
  ];

  public $filters = [
  ];

  public function orcamento()
  {
    return $this->belongsTo('App\Models\Orcamentos');
  }

  public function servico()
  {
    return $this->belongsTo('App\Models\Servicos');
  }
}
