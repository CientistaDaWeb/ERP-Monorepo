<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class MtrDados extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'mtr_id',
    'gerador_razao_social',
    'gerador_cnpj',
    'gerador_lo',
    'gerador_endereco',
    'gerador_municipio',
    'gerador_responsavel',
    'gerador_telefone',
    'gerador_ramal',
    'residuos',
    'quantidade',
    'transportador_razao_social',
    'transportador_cnpj',
    'transportador_endereco',
    'transportador_cep',
    'transportador_municipio',
    'transportador_uf',
    'transportador_fone',
    'transportador_equipamento',
    'transportador_condutor',
    'transportador_condutor_cpf',
    'transportador_lo',
    'transportador_lacre',
    'transportador_veiculo',
    'transportador_placa',
    'transportador_estado',
    'destinatario_razao_social',
    'destinatario_cnpj',
    'destinatario_municipio',
    'destinatario_uf',
    'destinatario_lo',
    'destinatario_fepam',
    'destinatario_fone',
    'destinatario_motivo',
    'destinatario_responsavel',
    'destinatario_email',
    'descricao',
    'instrucoes',
    'responsavel_gerador',
    'responsavel_transportador',
    'responsavel_receptor',
    'discrepancia',
    'instalacao_receptor',
    'gerador_cep',
    'gerador_email'
  ];

  public $filters = [
  ];
}
