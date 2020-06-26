<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Cfops extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'codigo',
    'descricao'
  ];

  public $filters = [
    'descricao' =>
      [
        'column' => 'descricao',
        'type' => 'like'
      ],
    'codigo' =>
      [
        'column' => 'codigo',
        'type' => 'like'
      ],
  ];
}
