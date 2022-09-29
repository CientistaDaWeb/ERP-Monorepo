<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class NotasFiscaisController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['orcamento.cliente', 'empresa'];

  public function __construct(\App\Models\NotasFiscais $model)
  {
    $this->model = $model;
  }
}
