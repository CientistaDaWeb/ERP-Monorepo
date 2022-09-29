<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ArquitetosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\Arquitetos $model)
  {
    $this->model = $model;
  }
}
