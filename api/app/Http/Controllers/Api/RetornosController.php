<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class RetornosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['banco.empresa'];

  public function __construct(\App\Models\Retornos $model)
  {
    $this->model = $model;
  }
}
