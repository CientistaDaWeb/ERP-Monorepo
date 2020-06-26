<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContasReceber;
use App\Models\ContasReceberOrdensServicos;
use App\Models\OrdensServico;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContasReceberController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['orcamento.cliente', 'empresa', 'formaPagamento'];

  public function __construct(\App\Models\ContasReceber $model)
  {
    $this->model = $model;
  }

  public function atrasadas()
  {
    $hoje = Carbon::today();
    $result = $this->model
      ->with('orcamento.cliente')
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
      ->with('orcamento.cliente')
      ->where('data_vencimento', '>=', $hoje)
      ->where('data_vencimento', '<=', $dataFinal)
      ->whereNull('valor_pago')
      ->orderBy('data_vencimento')
      ->get();

    return response()->json($result);
  }

  public function salvaParcelas(Request $request)
  {
    $data = $request->all();
    foreach ($data['parcelas'] as $parcela) {
      $parcela['orcamento_id'] = $data['orcamento_id'];
      $parcela['forma_pagamento_id'] = $data['forma_pagamento_id'];
      $parcela['endereco_id'] = $data['endereco_id'];
      $parcela['empresa_id'] = $data['empresa_id'];
      $parcela['observacoes'] = $data['observacoes'] ?? null;
      $parcela['descricao'] = $data['descricao'] ?? null;
      $parcela['data_vencimento'] = Carbon::createFromTimeString($parcela['data']);
      $parcela['data_lancamento'] = date('Y-m-d');
      $parcela['valor_retido'] = $parcela['valor_retido'];
      $parcela['valor'] = $parcela['valor'];

      $contaReceber = ContasReceber::create($parcela);

      if ($data['os']) {
        foreach ($data['os'] as $os) {
          $dados = [
            'conta_receber_id' => $contaReceber->id,
            'ordem_servico_id' => $os
          ];
          ContasReceberOrdensServicos::create($dados);
          $ordemServico = OrdensServico::findOrFail($os);
          $ordemServico->update(['faturado' => 'S']);
        }
      }
    }
    $result = 'Parcelas criadas com sucesso!';
    return response()->json($result);
  }
}
