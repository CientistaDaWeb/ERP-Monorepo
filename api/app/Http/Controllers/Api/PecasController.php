<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class PecasController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['manutencoesPecas'];

  public function __construct(\App\Models\Pecas $model)
  {
    $this->model = $model;
  }
}
