<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class MunicipiosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['estado'];

  public function __construct(\App\Models\Municipios $model)
  {
    $this->model = $model;
  }
}
