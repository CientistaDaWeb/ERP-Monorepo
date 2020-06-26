<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OrdensServicoController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['orcamento.cliente', 'empresa'];

  public function __construct(\App\Models\OrdensServico $model)
  {
    $this->model = $model;
  }

  public function atrasadas()
  {
    $hoje = Carbon::today();
    $result = $this->model
      ->with('orcamento.cliente')
      ->where('status', '1')
      ->where('data_coleta', '<=', $hoje)
      ->orderBy('data_coleta')
      ->get();

    return response()->json($result);
  }

  public function vencendo()
  {
    $dataFinal = Carbon::today()->addDays(15);
    $hoje = Carbon::today();

    $result = $this->model
      ->with('orcamento.cliente')
      ->where('status', '1')
      ->where('data_coleta', '>=', $hoje)
      ->where('data_coleta', '<=', $dataFinal)
      ->orderBy('data_coleta')
      ->get();

    return response()->json($result);
  }
}
