<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UsuariosModulosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\UsuariosModulos $model)
  {
    $this->model = $model;
  }
}
