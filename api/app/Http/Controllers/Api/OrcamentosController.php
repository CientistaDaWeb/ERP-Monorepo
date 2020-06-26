<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class OrcamentosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['cliente', 'empresa', 'ordensServico', 'contasReceber', 'usuario'];

  public function __construct(\App\Models\Orcamentos $model)
  {
    $this->model = $model;
  }

  public function abertos()
  {
    $result = $this->model
      ->with('cliente')
      ->with('usuario')
      ->where('status', '2')
      ->orderBy('data_emissao')
      ->get();

    return response()->json($result);
  }

  public function divergencias()
  {
    $result = $this->model
      ->with('cliente')
      ->with('usuario')
      ->with('ordensServico')
      ->with('contasReceber')
      ->where('status', '3')
      ->orderBy('data_emissao')
      ->get();

    foreach ($result AS $key => $item) {
      $saldo = $item->contasReceber()->sum('valor') - $item->ordensServico()->sum('valor') - $item->ordensServico()->sum('desconto');
      if ($saldo >= -1 AND $saldo <= 1) {
        unset($result[$key]);
      } else {
        $item->saldo = $saldo;

      }
    }

    return response()->json($result);
  }
}
