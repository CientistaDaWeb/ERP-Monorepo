<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class UsuariosModulos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'usuario_id',
    'modulo_id',
  ];

  public $filters = [
  ];

  public function usuario()
  {
    return $this->belongsTo('App\Models\Usuarios');
  }

  public function modulo()
  {
    return $this->belongsTo('App\Models\Modulos');
  }
}
