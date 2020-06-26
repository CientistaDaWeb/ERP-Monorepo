<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AbastecimentosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['aditivo', 'caminhao', 'fornecedor'];

  public function __construct(\App\Models\Abastecimentos $model)
  {
    $this->model = $model;
  }
}
