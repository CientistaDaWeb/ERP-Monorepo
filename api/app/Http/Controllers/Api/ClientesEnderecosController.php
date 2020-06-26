<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ClientesEnderecosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['categoria', 'municipio'];

  public function __construct(\App\Models\ClientesEnderecos $model)
  {
    $this->model = $model;
  }

  public function mapa()
  {
    $enderecos = $this->model->with('cliente', 'categoria')
      ->whereNotNull('coordenadas')
      ->where('coordenadas', '!=', '')
      ->get();
    return response()->json($enderecos);
  }
}
