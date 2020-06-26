<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrdemServicoImagens extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'ordem_servico_id',
    'arquivo',
    'legenda',
    'local'
  ];

  public $filters = [];

  public function ordemServico()
  {
    return $this->belongsTo('App\Models\OrdenServico');
  }
}
