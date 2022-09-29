<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ContasPagarCategoriaController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = [];

  public function __construct(\App\Models\ContasPagarCategorias $model)
  {
    $this->model = $model;
  }
}
