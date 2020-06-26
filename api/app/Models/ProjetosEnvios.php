<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosEnvios extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'projeto_id',
    'destinatarios',
    'remetente',
    'assunto',
    'mensagem'
  ];

  public $filters = [
    'remetente' =>
      [
        'column' => 'remetente',
        'type' => 'like'
      ],
    'assunto' =>
      [
        'column' => 'assunto',
        'type' => 'like'
      ],
    'mensagem' =>
      [
        'column' => 'mensagem',
        'type' => 'like'
      ]
  ];

  public function projeto()
  {
    return $this->belongsTo('App\Models\Projetos');
  }
}
