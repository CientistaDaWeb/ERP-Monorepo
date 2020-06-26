<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Transportadores extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'documento',
    'razao_social',
    'nome_fantasia',
    'inscricao_estadual',
    'inscricao_municipal',
    'email',
    'numero_fepan',
    'estado_id',
    'municipio_id',
    'cep',
    'endereco',
    'bairro',
    'numero',
    'complemento',
    'telefone',
    'telefone2',
    'telefone3',
    'lo',
  ];

  public $filters = [
    'razao_social' =>
      [
        'column' => 'razao_social',
        'type' => 'like'
      ],
    'nome_fantasia' =>
      [
        'column' => 'nome_fantasia',
        'type' => 'like'
      ]
  ];

  public function estado()
  {
    return $this->belongsTo('App\Models\Estados');
  }

  public function municipio()
  {
    return $this->belongsTo('App\Models\Municipio');
  }

  public function ordensServico()
  {
    return $this->hasMany('App\Models\OrdensServico', 'transportador_id', 'id');
  }

  protected $appends = ['ordensServicoCount'];

  public function getOrdensServicoCountAttribute()
  {
    return $this->ordensServico()->count();
  }
}
