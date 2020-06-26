<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ProjetosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['construtora', 'arquiteto', 'categoria'];

  public function __construct(\App\Models\Projetos $model)
  {
    $this->model = $model;
  }

  public function ppci()
  {
    $result = $this->model
      ->with('ultimaInteracao')
      ->has('ultimaInteracao')
      ->where('categoria_id', '!=', 1)
      ->where('status_ppci', '!=', 'C')
      ->get();
    return response()->json($result);
  }

  public function hidro()
  {

    $result = $this->model
      ->with('ultimaInteracao')
      ->has('ultimaInteracao')
      ->where('categoria_id', '!=', 2)
      ->where('status_hidro', '!=', 'C')
      ->get();
    return response()->json($result);
  }
}
