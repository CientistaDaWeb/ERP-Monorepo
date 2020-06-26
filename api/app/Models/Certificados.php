<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Certificados extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'mtr_id',
    'cliente_nome',
    'cliente_endereco',
    'cliente_cidade',
    'transportador_nome',
    'transportador_endereco',
    'transportador_lo',
    'quantidade',
    'tipo_efluente',
    'sequencial',
    'inicio_tratamento',
    'fim_tratamento'
  ];

  public $filters = [
    'cliente_nome' =>
      [
        'column' => 'cliente_nome',
        'type' => 'like'
      ],
    'mtr_id' =>
      [
        'column' => 'mtr_id',
        'type' => 'like'
      ],
  ];
}
