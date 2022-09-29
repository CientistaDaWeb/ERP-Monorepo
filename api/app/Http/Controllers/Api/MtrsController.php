<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class MtrsController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['ordemServico.orcamento.cliente', 'certificados'];

  public function __construct(\App\Models\Mtrs $model)
  {
    $this->model = $model;
  }
}
