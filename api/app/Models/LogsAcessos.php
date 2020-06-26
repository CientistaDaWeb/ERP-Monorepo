<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class LogsAcessos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'usuario_id',
    'ip',
    'navegador',
  ];

  public $filters = [
  ];

  public function usuario()
  {
    return $this->belongsTo('App\Models\Usuarios');
  }
}
