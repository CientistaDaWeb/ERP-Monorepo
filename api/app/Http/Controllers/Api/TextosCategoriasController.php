<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TextosCategoriasController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = [];

  public function __construct(\App\Models\TextosCategorias $model)
  {
    $this->model = $model;
  }
}
