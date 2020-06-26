<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ContratosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['orcamento.cliente', 'orcamento.empresa'];

  public function __construct(\App\Models\Contratos $model)
  {
    $this->model = $model;
  }
}
