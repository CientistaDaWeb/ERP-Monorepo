<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
class EmpresasArquivosCategorias extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'categoria'
  ];

  public $filters = [
    'categoria' =>
      [
        'column' => 'categoria',
        'type' => 'like'
      ]
  ];

  public function arquivos()
  {
    return $this->hasMany('App\Models\EmpresasArquivos', 'categoria_id', 'id');
  }

  protected $appends = ['arquivosCount'];

  public function getArquivosCountAttribute()
  {
    return $this->arquivos()->count();
  }
}
