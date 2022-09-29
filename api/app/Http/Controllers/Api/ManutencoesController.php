<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ManutencoesController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['fornecedor', 'pecas'];

  public function __construct(\App\Models\Manutencoes $model)
  {
    $this->model = $model;
  }
}
