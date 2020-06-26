<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class FornecedoresCrm extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'fornecedor_id',
    'usuario_id',
    'data',
    'descricao',
    'status',
  ];

  public $filters = [
  ];

  public function fornecedor()
  {
    return $this->belongsTo('App\Models\Fornecedores');
  }

  public function usuario()
  {
    return $this->belongsTo('App\Models\Usuarios');
  }
}
