<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class FormasPagamentoController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['banco'];

  public function __construct(\App\Models\FormasPagamento $model)
  {
    $this->model = $model;
  }
}
