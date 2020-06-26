<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class PesquisaSatisfacaoController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\PesquisaSatisfacao $model)
  {
    $this->model = $model;
  }
}
