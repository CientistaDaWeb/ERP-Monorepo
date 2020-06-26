<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AdministradoresCondominiosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\AdministradoresCondominios $model)
  {
    $this->model = $model;
  }
}
