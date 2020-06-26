<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ProjetosPpciController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\ProjetosPpci $model)
  {
    $this->model = $model;
  }
}
