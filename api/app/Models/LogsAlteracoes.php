<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class LogsAlteracoes extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'usuario_id',
    'pagina',
    'ip',
    'dados',
    'acao',
    'action',
    'table',
    'object_id',
  ];
  public $filters = [
  ];

  public function usuario()
  {
    return $this->belongsTo('App\Models\Usuarios');
  }
}
