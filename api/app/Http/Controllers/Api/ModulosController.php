<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModulosCategorias;

class ModulosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['categoria'];

  public function __construct(\App\Models\Modulos $model)
  {
    $this->model = $model;
  }

  public function menu($usuario_id)
  {
    $modules = ModulosCategorias::with(['modulos'])->orderBy('ordem')->get();
    return response()->json($modules);
  }
}
