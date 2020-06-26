<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'documento_tipo',
    'documento',
    'razao_social',
    'nome_fantasia',
    'inscricao_estadual',
    'contato',
    'email',
    'email_cobranca',
    'email_pesquisa',
    'numero_fepan',
    'sindico',
    'zelador',
    'administrador_id',
    'usuario',
    'senha',
    'observacoes',
    'site',
    'observacoes_faturamento',
    'categoria_id',
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
      ],

  ];

  public function administrador()
  {
    return $this->belongsTo('App\Models\AdministradoresCondominios', 'administrador_id', 'id');
  }

  public function categoria()
  {
    return $this->belongsTo('App\Models\ClientesCategorias');
  }

  public function telefones()
  {
    return $this->hasMany('App\Models\ClientesTelefones', 'cliente_id', 'id');
  }

  public function arquivos()
  {
    return $this->hasMany('App\Models\ClientesArquivos', 'cliente_id', 'id');
  }

  public function enderecos()
  {
    return $this->hasMany('App\Models\ClientesEnderecos', 'cliente_id', 'id');
  }

  public function orcamentos()
  {
    return $this->hasMany('App\Models\Orcamentos', 'cliente_id', 'id');
  }

  public function ultimoOrcamento()
  {
    return $this->hasOne('App\Models\Orcamentos', 'cliente_id', 'id')->orderBy('data_emissao', 'desc');
  }

  protected $appends = ['enderecosCount', 'orcamentosCount'];

  public function getEnderecosCountAttribute()
  {
    return $this->enderecos()->count();
  }

  public function getOrcamentosCountAttribute()
  {
    return $this->orcamentos()->count();
  }

}
