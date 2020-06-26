<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class LogsAcessosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\LogsAcessos $model)
  {
    $this->model = $model;
  }
}
