<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UsuariosCompromissosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  //protected $relationships = ['abastecimentos'];

  public function __construct(\App\Models\UsuariosCompromissos $model)
  {
    $this->model = $model;
  }

  public function compromissos()
  {
    $ontem = Carbon::yesterday();
    $semanaQuevem = Carbon::today()->addDays(5);
    $result = $this->model->with([
      'usuario',
      'cliente'
    ])
      ->where('status', 'A')
      ->whereBetween('data', [$ontem, $semanaQuevem])
      ->orderBy('data')
      ->orderBy('hora')
      ->get();

    return response()->json($result);
  }
}
