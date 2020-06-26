<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Bens extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'nome',
    'valor_compra',
    'data_aquisicao',
    'meses_quitacao'
  ];

  public $filters = [
    'nome' =>
      [
        'column' => 'nome',
        'type' => 'like'
      ],
  ];
}
