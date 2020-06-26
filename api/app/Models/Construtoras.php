<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
class Construtoras extends LogTrait
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

  ];

  public function projetos()
  {
    return $this->hasMany('App\Models\Projetos', 'construtora_id', 'id');
  }

  protected $appends = ['projetosCount'];

  public function getProjetosCountAttribute()
  {
    return $this->projetos()->count();
  }
}
