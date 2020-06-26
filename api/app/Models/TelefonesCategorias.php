<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class TelefonesCategorias extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'categoria',
  ];

  public $filters = [
    'categoria' =>
      [
        'column' => 'categoria',
        'type' => 'like'
      ]
  ];

  public function telefones()
  {
    return $this->hasMany('App\Models\ClientesTelefones', 'categoria_id', 'id');
  }

  protected $appends = ['telefonesCount'];

  public function getTelefonesCountAttribute()
  {
    return $this->telefones()->count();
  }
}
