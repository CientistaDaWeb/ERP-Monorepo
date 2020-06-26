<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ContasPagarController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['empresa', 'fornecedor', 'categoria', 'formaPagamento'];

  public function __construct(\App\Models\ContasPagar $model)
  {
    $this->model = $model;
  }

  public function atrasadas()
  {
    $hoje = Carbon::today();
    $result = $this->model
      ->with('fornecedor')
      ->where('data_vencimento', '<=', $hoje)
      ->whereNull('valor_pago')
      ->orderBy('data_vencimento')
      ->get();

    return response()->json($result);
  }

  public function vencendo()
  {
    $dataFinal = Carbon::today()->addDays(15);
    $hoje = Carbon::today();

    $result = $this->model
      ->with('fornecedor')
      ->where('data_vencimento', '>=', $hoje)
      ->where('data_vencimento', '<=', $dataFinal)
      ->whereNull('valor_pago')
      ->orderBy('data_vencimento')
      ->get()
    ;

    return response()->json($result);
  }
}
