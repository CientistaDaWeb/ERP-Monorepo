<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ServicosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['categoria'];

  public function __construct(\App\Models\Servicos $model)
  {
    $this->model = $model;
  }
}
