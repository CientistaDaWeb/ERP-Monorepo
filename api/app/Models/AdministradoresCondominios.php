<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class AdministradoresCondominios extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'nome',
    'telefone',
    'telefone2',
    'telefone3',
    'email',
    'contato',
    'endereco',
  ];

  public $filters = [
    'nome' =>
      [
        'column' => 'nome',
        'type' => 'like'
      ],
    'telefone' =>
      [
        'column' => 'telefone',
        'type' => 'like'
      ],
    'telefone_2' =>
      [
        'column' => 'telefone_2',
        'type' => 'like'
      ],
    'telefone_3' =>
      [
        'column' => 'telefone_3',
        'type' => 'like'
      ],
    'contato' =>
      [
        'column' => 'contato',
        'type' => 'like'
      ],
  ];

  public function clientes()
  {
    return $this->hasMany('App\Models\Clientes');
  }

}
