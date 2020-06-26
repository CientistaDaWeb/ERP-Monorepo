<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class UsuariosCompromissos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'usuario_id',
    'cliente_id',
    'titulo',
    'local',
    'descricao',
    'data',
    'hora',
    'status',
  ];

  public $filters = [
    'titulo' =>
      [
        'column' => 'titulo',
        'type' => 'like'
      ],
    'descricao' =>
      [
        'column' => 'descricao',
        'type' => 'like'
      ]
  ];

  public function usuario()
  {
    return $this->belongsTo('App\Models\Usuarios');
  }

  public function cliente()
  {
    return $this->belongsTo('App\Models\Clientes');
  }
}
