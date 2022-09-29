<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BancosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['empresa'];

  public function __construct(\App\Models\Bancos $model)
  {
    $this->model = $model;
  }
}
