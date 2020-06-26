<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FormasPagamento extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $table = 'formas_pagamento';

  protected $fillable = [
    'banco_id',
    'forma_pagamento',
    'gera_remesssa'
  ];

  public $filters = [
    'forma_pagamento' =>
      [
        'column' => 'forma_pagamento',
        'type' => 'like'
      ]
  ];

  public function banco()
  {
    return $this->belongsTo('App\Models\Bancos');
  }

  public function contasReceber()
  {
    return $this->hasMany('App\Models\ContasReceber', 'forma_pagamento_id', 'id');
  }

  protected $appends = ['contasReceberCount'];

  public function getContasReceberCountAttribute()
  {
    return $this->contasReceber()->count();
  }
}
