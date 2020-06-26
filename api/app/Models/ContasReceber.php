<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContasReceber extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $table = 'contas_receber';

  protected $fillable = [
    'empresa_id',
    'orcamento_id',
    'forma_pagamento_id',
    'remessa_id',
    'retorno_id',
    'data_vencimento',
    'valor',
    'data_vencimento',
    'valor',
    'data_pagamento',
    'valor_pago',
    'valor_retido',
    'descricao',
    'data_lancamento',
    'endereco_id',
    'observacoes',
    'cte_id',
    'nf_id',
    'cte_acqualife_id',
    'cte_acquaservicos_id'
  ];

  public $filters = [
    'observacoes' =>
      [
        'column' => 'observacoes',
        'type' => 'like'
      ],
    'data_vencimento' =>
      [
        'column' => 'data_vencimento',
        'type' => 'date'
      ],
    'data_lancamento' =>
      [
        'column' => 'data_lancamento',
        'type' => 'date'
      ],
  ];

  public function cte()
  {
    return $this->belongsTo('App\Models\Ctes');
  }

  public function cteAcqualife()
  {
    return $this->belongsTo('App\Models\CtesAcqualife');
  }

  public function cteAcquaservicos()
  {
    return $this->belongsTo('App\Models\CtesAcquaservicos');
  }

  public function empresa()
  {
    return $this->belongsTo('App\Models\Empresas');
  }

  public function endereco()
  {
    return $this->belongsTo('App\Models\ClientesEnderecos');
  }

  public function orcamento()
  {
    return $this->belongsTo('App\Models\Orcamentos');
  }

  public function formaPagamento()
  {
    return $this->belongsTo('App\Models\FormasPagamento');
  }

  public function remessa()
  {
    return $this->belongsTo('App\Models\Remessas');
  }

  public function retorno()
  {
    return $this->belongsTo('App\Models\Retornos');
  }

  protected $appends = ['status'];

  public function getStatusAttribute()
  {
    $dt = Carbon::createFromFormat('Y-m-d',$this->data_vencimento);

    if (!empty($this->valor_pago)):
      return 'pago';
    elseif ($dt->isFuture()):
      return 'aberto';
    else:
      return 'atrasada';
    endif;
  }
}
