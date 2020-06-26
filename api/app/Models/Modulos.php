<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Modulos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'categoria_id',
    'titulo',
    'controller',
    'ordem',
    'route',
    'action',
    'icon'
  ];

  public $filters = [
    'titulo' =>
      [
        'column' => 'titulo',
        'type' => 'like'
      ]
  ];

  public function categoria()
  {
    return $this->belongsTo('App\Models\ModulosCategorias', 'categoria_id', 'id');
  }
}
