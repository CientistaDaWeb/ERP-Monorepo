<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class EmpresasController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\Empresas $model)
  {
    $this->model = $model;
  }
}
