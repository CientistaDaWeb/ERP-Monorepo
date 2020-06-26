<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class FornecedoresController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['contasPagar', 'categoria'];

  public function __construct(\App\Models\Fornecedores $model)
  {
    $this->model = $model;
  }
}
