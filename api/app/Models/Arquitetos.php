<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Arquitetos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'nome',
    'contato',
    'telefone',
    'telefone_2',
    'telefone_3'
  ];

  public $filters = [
    'nome' =>
      [
        'column' => 'nome',
        'type' => 'like'
      ],
    'contato' =>
      [
        'column' => 'contato',
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
      ]
  ];

}
