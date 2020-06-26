<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class TextosCategorias extends LogTrait
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

  public function textos()
  {
    return $this->hasMany('App\Models\Textos', 'categoria_id', 'id');
  }

  protected $appends = ['textosCount'];

  public function getTextosCountAttribute()
  {
    return $this->textos()->count();
  }

}
