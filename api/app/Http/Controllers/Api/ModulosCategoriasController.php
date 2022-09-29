<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ModulosCategoriasController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = [];

  public function __construct(\App\Models\ModulosCategorias $model)
  {
    $this->model = $model;
  }
}
