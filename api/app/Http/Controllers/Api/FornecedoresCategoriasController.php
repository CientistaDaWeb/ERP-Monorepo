<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class FornecedoresCategoriasController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = [];

  public function __construct(\App\Models\FornecedoresCategorias $model)
  {
    $this->model = $model;
  }
}
