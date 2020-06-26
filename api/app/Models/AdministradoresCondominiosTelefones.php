<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AdministradoresCondominiosTelefones extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'administrador_condominio_id',
    'categoria_id',
    'telefone',
    'informacao',
    'email',
    'contato',
    'padrao'
  ];

  public $filters = [
    'contato' =>
      [
        'column' => 'contato',
        'type' => 'like'
      ],
    ];
}
