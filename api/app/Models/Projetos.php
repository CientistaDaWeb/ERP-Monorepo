<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Projetos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'categoria_id',
    'construtora_id',
    'arquiteto_id',
    'nome',
    'proprietario',
    'endereco',
    'observacoes',
    'diretorio',
    'numero_protocolo',
    'status_ppci',
    'status_hidro'
  ];

  public $filters = [
    'nome' =>
      [
        'column' => 'nome',
        'type' => 'like'
      ]
  ];

  public function categoria()
  {
    return $this->belongsTo('App\Models\ProjetosCategorias');
  }

  public function construtora()
  {
    return $this->belongsTo('App\Models\Construtoras');
  }

  public function arquiteto()
  {
    return $this->belongsTo('App\Models\Arquitetos');
  }

  public function alteracoes()
  {
    return $this->hasMany('App\Models\ProjetosAlteracoes');
  }

  public function atividades()
  {
    return $this->hasMany('App\Models\ProjetosAtividades');
  }

  public function ultimaInteracao()
  {
    return $this->hasOne('App\Models\ProjetosCrm', 'projeto_id', 'id')->orderBy('data', 'DESC');
  }
}
