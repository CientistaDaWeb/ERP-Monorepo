<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class CtesAcqualife extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'cfop_id',
    'cliente_id',
    'endereco_id',
    'destinatario_id',
    'destinatario_endereco_id',
    'expedidor_id',
    'expedidor_endereco_id',
    'recebedor_id',
    'recebedor_endereco_id',
    'status',
    'lote',
    'protocolo',
    'protocolo_sefaz',
    'rtnrc',
    'quantidade',
    'codigo',
    'chave',
    'observacoes',
    'doc_tipo',
    'doc_numero',
    'doc_data_emissao',
    'doc_valor',
    'doc_descricao',
    'toma',
    'nfe_chave',
    'nfe_pin',
    'nfe_data_emissao',
    'valor_carga'
  ];
}
