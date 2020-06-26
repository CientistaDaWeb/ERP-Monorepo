<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AditivosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\Aditivos $model)
  {
    $this->model = $model;
  }
}
