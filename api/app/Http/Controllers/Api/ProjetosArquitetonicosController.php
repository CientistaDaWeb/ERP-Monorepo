<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ProjetosArquitetonicosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\ProjetosArquitetonicos $model)
  {
    $this->model = $model;
  }
}
