<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Pecas extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'nome'
  ];

  public $filters = [
    'nome' =>
      [
        'column' => 'nome',
        'type' => 'like'
      ]
  ];

  public function manutencoesPecas()
  {
    return $this->hasMany('App\Models\ManutencoesPecas', 'peca_id', 'id');
  }

  protected $appends = ['manutencoesCount'];

  public function getManutencoesCountAttribute()
  {
    return $this->manutencoesPecas()->count();
  }
}
