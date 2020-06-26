<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ServicosCategorias extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'categoria'
  ];

  public $filters = [
    'categoria' =>
      [
        'column' => 'categoria',
        'type' => 'like'
      ]
  ];

  protected $appends = ['servicosCount'];

  public function servicos()
  {
    return $this->hasMany('App\Models\Servicos', 'categoria_id', 'id');
  }

  public function getServicosCountAttribute()
  {
    return $this->servicos()->count();
  }
}
