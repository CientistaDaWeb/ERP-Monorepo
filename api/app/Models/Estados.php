<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Estados extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'estado',
    'uf',
    'codigo'
  ];

  public $filters = [
    'estado' =>
      [
        'column' => 'estado',
        'type' => 'like'
      ],
    'uf' =>
      [
        'column' => 'uf',
        'type' => 'like'
      ]
  ];
}
