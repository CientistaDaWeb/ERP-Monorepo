<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ClientesController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['categoria', 'telefones'];

  public function __construct(\App\Models\Clientes $model)
  {
    $this->model = $model;
  }
}
