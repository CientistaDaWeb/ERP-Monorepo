<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class PesquisaSatisfacao extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'certificado_id',
    'atendimento_telefone',
    'atendimento_coleta',
    'documentacao',
    'atendimento_servico',
    'recomendaria',
    'observacoes',
    'data'
  ];

  public $filters = [];

  public function certificado()
  {
    return $this->belongsTo('App\Models\Certificados');
  }
}
