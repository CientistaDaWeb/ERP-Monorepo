<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Bancos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'empresa_id',
    'banco',
    'agencia',
    'conta_corrente',
    'carteira'
  ];

  public $filters = [
    'banco' =>
      [
        'column' => 'banco',
        'type' => 'like'
      ],
    'agencia' =>
      [
        'column' => 'agencia',
        'type' => 'like'
      ],
    'conta_corrente' =>
      [
        'column' => 'conta_corrente',
        'type' => 'like'
      ],
    'carteira' =>
      [
        'column' => 'carteira',
        'type' => 'like'
      ],
  ];

  public function empresa()
  {
    return $this->belongsTo('App\Models\Empresas');
  }
}
