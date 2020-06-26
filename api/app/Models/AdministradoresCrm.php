<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AdministradoresCrm extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $table = 'administradores_crm';

  protected $fillable = [
    'administrador_id',
    'usuario_id',
    'data',
    'descricao',
    'status'
  ];

  public $filters = [
    'descricao' =>
      [
        'column' => 'descricao',
        'type' => 'like'
      ],
    ];
}
