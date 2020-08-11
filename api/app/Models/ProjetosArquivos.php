<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosArquivos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'categoria_id',
    'projeto_id',
    'arquivo',
    'descricao'
  ];

  public $filters = [
    'arquivo' =>
      [
        'column' => 'arquivo',
        'type' => 'like'
      ],
    'descricao' =>
      [
        'column' => 'descricao',
        'type' => 'like'
      ]
  ];

  public function categoria()
  {
    return $this->belongsTo(ProjetosCategorias::class);
  }

  public function projeto()
  {
    return $this->belongsTo(Projetos::class);
  }
}
