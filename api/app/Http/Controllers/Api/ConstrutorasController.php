<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ConstrutorasController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['projetos'];

  public function __construct(\App\Models\Construtoras $model)
  {
    $this->model = $model;
  }
}
