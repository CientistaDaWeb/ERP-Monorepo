<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Manutencoes extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'fornecedor_id',
    'data',
    'valor',
    'observacoes'
  ];

  public $filters = [
    'observacoes' => [
      'column' => 'observacoes',
      'type' => 'like'
    ]
  ];

  public function fornecedor()
  {
    return $this->belongsTo('App\Models\Fornecedores');
  }

  public function pecas()
  {
    return $this->hasMany('App\Models\ManutencoesPecas', 'manutencao_id', 'id');
  }

  protected $appends = ['pecasCount'];

  public function getPecasCountAttribute()
  {
    return $this->pecas()->count();
  }
}
