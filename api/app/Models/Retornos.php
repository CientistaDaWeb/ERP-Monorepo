<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Retornos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'banco_id',
    'arquivo',
    'data_recebimento'
  ];

  public $filters = [
    'arquivo' =>
      [
        'column' => 'arquivo',
        'type' => 'like'
      ],
  ];

  public function banco()
  {
    return $this->belongsTo('App\Models\Bancos');
  }

  public function contasReceber()
  {
    return $this->hasMany('App\Models\ContasReceber', 'retorno_id', 'id');
  }

  protected $appends = ['contasReceberCount'];

  public function getContasReceberCountAttribute()
  {
    return $this->contasReceber()->count();
  }

}
