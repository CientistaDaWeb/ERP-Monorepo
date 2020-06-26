<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class AdministradoresArquivos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'administrador_id',
    'arquivo',
    'descricao',
  ];

  public $filters = [
    'descricao' =>
      [
        'column' => 'descricao',
        'type' => 'like'
      ],
    'arquivo' =>
      [
        'column' => 'arquivo',
        'type' => 'like'
      ]
  ];

  public function administrador()
  {
    return $this->belongsTo('App\Models\AdministradoresCondominios');
  }

}
