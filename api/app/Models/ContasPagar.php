<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContasPagar extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';
  protected $table = 'contas_pagar';

  public static function boot()
  {
    parent::boot();
    self::saving(
      function ($model) {
        if (empty($model->data_lancamento)) {
          $model->data_lancamento = date('Y-m-d');
        }
      }
    );
  }

  protected $fillable = [
    'empresa_id',
    'fornecedor_id',
    'categoria_id',
    'forma_pagamento_id',
    'conta_fixa',
    'valor',
    'data_vencimento',
    'valor_pago',
    'data_pagamento',
    'data_lancamento',
    'observacoes'
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

  public function empresa()
  {
    return $this->belongsTo('App\Models\Empresas');
  }

  public function fornecedor()
  {
    return $this->belongsTo('App\Models\Fornecedores');
  }

  public function categoria()
  {
    return $this->belongsTo('App\Models\ContasPagarCategorias', 'categoria_id', 'id');
  }

  public function formaPagamento()
  {
    return $this->belongsTo('App\Models\FormasPagamento', 'forma_pagamento_id');
  }

  protected $appends = ['status'];

  public function getStatusAttribute()
  {
    $dt = Carbon::createFromFormat('Y-m-d', $this->data_vencimento);

    if ($this->valor_pago > 0.01 OR !is_null($this->data_pagamento)):
      return 'pago';
    elseif ($dt->isFuture()):
      return 'aberto';
    else:
      return 'atrasada';
    endif;
  }

}
