<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ManutencoesPecasController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\ManutencoesPecas $model)
  {
    $this->model = $model;
  }
}
