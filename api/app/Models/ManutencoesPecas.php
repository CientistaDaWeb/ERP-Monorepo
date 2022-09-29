<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ManutencoesPecas extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'manutencao_id',
    'peca_id',
    'qtde',
    'valor'
  ];

  public $filters = [
  ];

  public function manutencao()
  {
    return $this->belongsTo(Manutencoes::class);
  }

  public function peca()
  {
    return $this->belongsTo(Pecas::class);
  }

}
