<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Folgas extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'titulo',
    'data',
    'hora_inicio',
    'hora_fim'
  ];
  public $filters = [
  ];
}
