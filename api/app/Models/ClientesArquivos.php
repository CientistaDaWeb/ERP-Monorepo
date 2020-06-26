<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ClientesArquivos extends LogTrait
{
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $fillable = [
    'cliente_id',
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

  public function cliente()
  {
    return $this->belongsTo('App\Models\Clientes');
  }

  protected $appends = ['link'];

  public function getLinkAttribute()
  {
    if ($this->arquivo) {
      return Storage::temporaryUrl($this->arquivo, now()->addDay(6));
    }
  }

}

