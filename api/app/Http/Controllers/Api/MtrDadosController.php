<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class MtrDadosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\MtrDados $model)
  {
    $this->model = $model;
  }
}
