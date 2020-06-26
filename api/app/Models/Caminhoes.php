<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Caminhoes extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'nome',
    'placa'
  ];

  public $filters = [
    'nome' =>
      [
        'column' => 'nome',
        'type' => 'like'
      ],
    'placa' =>
      [
        'column' => 'placa',
        'type' => 'like'
      ],
  ];
}
