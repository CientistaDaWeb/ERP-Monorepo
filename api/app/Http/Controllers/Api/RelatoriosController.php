<?php

namespace App\Http\Controllers\Api;

use Aws\Result;
use Carbon\Carbon;
use App\Models\Clientes;
use App\Models\Orcamentos;
use App\Models\ClientesCrm;
use App\Models\ContasPagar;
use App\Models\NotasFiscais;
use Illuminate\Http\Request;
use App\Models\ContasReceber;
use App\Models\NotasProjetos;
use App\Models\OrdensServico;
use App\Http\Services\ClientesCsv;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\FluxoCaixaCsv;
use App\Http\Services\OrcamentosCsv;
use App\Http\Services\ContasPagarCsv;
use App\Http\Services\AtendimentosCsv;
use App\Http\Services\NotasFiscaisCsv;
use App\Http\Services\NotasProjetoCsv;
use App\Http\Services\OrdemServicoCsv;
use App\Http\Services\ContasReceberCsv;
use App\Http\Services\ClientesCondominioCsv;

class RelatoriosController extends Controller
{

  public function fluxoCaixa(Request $request)
  {
    $data = $request->all();

    $fluxo = $this->filtrarFluxoCaixa($data);

    return response()->json($fluxo);
  }

  public function fluxoCaixaCsv(Request $request)
  {
    $data = $request->all();

    $fluxo = $this->filtrarFluxoCaixa($data);

    $csv = new FluxoCaixaCsv($fluxo);

    return ['arq' => $csv->geraCsv()];
  }

  public function ordemServico(Request $request)
  {
    $data = $request->all();

    $os = $this->filtrarOrdemServico($data);

    return response()->json($os);
  }

  public function ordemServicoCsv(Request $request)
  {
    $data = $request->all();

    $os = $this->filtrarOrdemServico($data);

    $csv = new OrdemServicoCsv($os);

    return ['arq' => $csv->geraCsv()];
  }

  public function orcamento(Request $request)
  {
    $data = $request->all();


    return response()->json($this->filtrarOrcamentos($data));
  }

  public function orcamentosCsv(Request $request)
  {
    $data = $request->all();

    $orcamentos = $this->filtrarOrcamentos($data);

    $csv = new OrcamentosCsv($orcamentos);

    return ['arq' => $csv->geraCsv()];
  }

  public function atendimento(Request $request)
  {
    $data = $request->all();

    return response()->json($this->filtrarAtendimentos($data));
  }

  public function atendimentosCsv(Request $request)
  {
    $data = $request->all();

    $atendimentos = $this->filtrarAtendimentos($data);

    $csv = new AtendimentosCsv($atendimentos);

    return ['arq' => $csv->geraCsv()];
  }

  public function contasPagar(Request $request)
  {
    $data = $request->all();

    $contasPagar = $this->filtrarContasPagar($data);

    return response()->json($contasPagar);
  }

  public function contasPagarCsv(Request $request)
  {
    $data = $request->all();

    $contasPagar = $this->filtrarContasPagar($data);

    $csv = new ContasPagarCsv($contasPagar);

    return ['arq' => $csv->geraCsv()];
  }

  public function contasReceber(Request $request)
  {
    $data = $request->all();

    $contasReceber = $this->filtrarContasReceber($data);

    return response()->json($contasReceber);
  }

  public function contasReceberCsv(Request $request)
  {
    $data = $request->all();

    $contasReceber = $this->filtrarContasReceber($data);

    $csv = new ContasReceberCsv($contasReceber);

    return ['arq' => $csv->geraCsv()];
  }

  public function clientesCondomonio(Request $request)
  {
    $data = $request->all();

    $cliCond = $this->filtrarCliCond($data);

    return response()->json($cliCond);
  }

  public function clientesCondominioCsv(Request $request)
  {
    $data = $request->all();

    $cliCond = $this->filtrarCliCond($data);

    $csv = new ClientesCondominioCsv($cliCond);

    return ['arq' => $csv->geraCsv()];
  }

  public function notaFiscal(Request $request)
  {
    $data = $request->all();

    $notas = $this->filtrarNotas($data);

    return response()->json($notas);
  }

  public function notaFiscalCsv(Request $request)
  {
    $data = $request->all();

    $notas = $this->filtrarNotas($data);

    $csv = new NotasFiscaisCsv($notas);

    return ['arq' => $csv->geraCsv()];
  }

  public function notaProjeto(Request $request)
  {
    $data = $request->all();

    $notas = $this->filtrarNotasProjeto($data);

    return response()->json($notas);
  }

  public function notaProjetoCsv(Request $request)
  {
    $data = $request->all();

    $notas = $this->filtrarNotasProjeto($data);

    $csv = new NotasProjetoCsv($notas);

    return ['arq' => $csv->geraCsv()];
  }

  public function cliente(Request $request)
  {
    $clientes = $this->filtrarClientes();

    return response()->json($clientes);
  }

  public function clienteCsv(Request $request)
  {
    $clientes = $this->filtrarClientes();

    $csv = new ClientesCsv($clientes);

    return ['arq' => $csv->geraCsv()];
  }

  private function filtrarOrcamentos($data)
  {
    $query = Orcamentos::with('cliente', 'empresa', 'usuario');

    $dataInicial = Carbon::now()->endOfMonth();
    $dataFinal = Carbon::now()->subMonths(6)->firstOfMonth();

    if ($data['data_inicial']) {
      $dataInicial = new Carbon($data['data_inicial']);
    }
    if ($data['data_final']) {
      $dataFinal = new Carbon($data['data_final']);
    }
    $query->whereBetween('data_emissao', [$dataInicial, $dataFinal]);

    if ($data['status']) {
      $query->where('status', $data['status']);
    }

    if ($data['empresa_id']) {
      $query->where('empresa_id', $data['empresa_id']);
    }

    if ($data['usuario_id']) {
      $query->where('usuario_id', $data['usuario_id']);
    }

    if ($data['cliente_id']) {
      $query->where('cliente_id', $data['cliente_id']);
    }

    return $query->get();
  }

  private function filtrarAtendimentos($data)
  {
    $query = ClientesCrm::with('cliente', 'usuario');

    $dataInicial = Carbon::now()->endOfMonth();
    $dataFinal = Carbon::now()->subMonths(6)->firstOfMonth();

    if ($data['data_inicial']) {
      $dataInicial = new Carbon($data['data_inicial']);
    }
    if ($data['data_final']) {
      $dataFinal = new Carbon($data['data_final']);
    }
    $query->whereBetween('data', [$dataInicial, $dataFinal]);

    if ($data['status']) {
      $query->where('status', $data['status']);
    }

    if ($data['usuario_id']) {
      $query->where('usuario_id', $data['usuario_id']);
    }

    if ($data['cliente_id']) {
      $query->where('cliente_id', $data['cliente_id']);
    }

    return $query->get();
  }

  private function filtrarContasPagar($data)
  {

    $query = ContasPagar::with('empresa', 'fornecedor.categoria', 'categoria', 'formaPagamento');

    if (isset($data['data_vencimento_inicial'])) {
      $dataInicial = new Carbon($data['data_vencimento_inicial']);
    }
    if (isset($data['data_vencimento_final'])) {
      $dataFinal = new Carbon($data['data_vencimento_final']);
      $query->whereBetween('data_vencimento', [$dataInicial, $dataFinal]);
    }

    if (isset($data['data_pagamento_inicial'])) {
      $dataInicial = new Carbon($data['data_pagamento_inicial']);
    }
    if (isset($data['data_pagamento_final'])) {
      $dataFinal = new Carbon($data['data_pagamento_final']);
      $query->whereBetween('data_pagamento', [$dataInicial, $dataFinal]);
    }

    if (isset($data['data_lancamento_inicial'])) {
      $dataInicial = new Carbon($data['data_lancamento_inicial']);
    }
    if (isset($data['data_lancamento_final'])) {
      $dataFinal = new Carbon($data['data_lancamento_final']);
      $query->whereBetween('data_lancamento', [$dataInicial, $dataFinal]);
    }

    if (isset($data['empresa_id'])) {
      $query->where('empresa_id', $data['empresa_id']);
    }

    if (isset($data['categoria_id'])) {
      $query->where('categoria_id', $data['categoria_id']);
    }

    if (isset($data['conta_fixa'])) {
      $query->where('conta_fixa', $data['conta_fixa']);
    }

    if (isset($data['fornecedor_categoria_id'])) {
      $query->whereHas('fornecedor', function ($query) use ($data) {
        $query->where('categoria_id', $data['fornecedor_categoria_id']);
      });
    }

    if (isset($data['fornecedor_id'])) {
      $query->where('fornecedor_id', $data['fornecedor_id']);
    }

    if (isset($data['forma_pagamento_id'])) {
      $query->where('forma_pagamento_id', $data['forma_pagamento_id']);
    }

    $result = $query->get();

    if (isset($data['status'])) {
      $result = $result->filter(function ($model) use ($data) {
        return $model->status === $data['status'];
      });
    }
    return $result;
  }

  private function filtrarContasReceber($data)
  {

    $query = ContasReceber::with('empresa', 'orcamento.cliente', 'formaPagamento');

    if (isset($data['data_vencimento_inicial'])) {
      $dataInicial = new Carbon($data['data_vencimento_inicial']);
    }
    if (isset($data['data_vencimento_final'])) {
      $dataFinal = new Carbon($data['data_vencimento_final']);
      $query->whereBetween('data_vencimento', [$dataInicial, $dataFinal]);
    }

    if (isset($data['data_pagamento_inicial'])) {
      $dataInicial = new Carbon($data['data_pagamento_inicial']);
    }
    if (isset($data['data_pagamento_final'])) {
      $dataFinal = new Carbon($data['data_pagamento_final']);
      $query->whereBetween('data_pagamento', [$dataInicial, $dataFinal]);
    }

    if (isset($data['data_lancamento_inicial'])) {
      $dataInicial = new Carbon($data['data_lancamento_inicial']);
    }
    if (isset($data['data_lancamento_final'])) {
      $dataFinal = new Carbon($data['data_lancamento_final']);
      $query->whereBetween('data_lancamento', [$dataInicial, $dataFinal]);
    }

    if (isset($data['empresa_id'])) {
      $query->where('empresa_id', $data['empresa_id']);
    }

    if (isset($data['cliente_id'])) {
      $query->whereHas('orcamento', function ($query) use ($data) {
        $query->where('cliente_id', $data['cliente_id']);
      });
    }

    if (isset($data['forma_pagamento_id'])) {
      $query->where('forma_pagamento_id', $data['forma_pagamento_id']);
    }

    $result = $query->get();

    if (isset($data['status'])) {
      $result = $result->filter(function ($model) use ($data) {
        return $model->status === $data['status'];
      });
    }

    return $result;
  }

  private function filtrarCliCond($data)
  {
    $admin = json_decode($data['administrador_id']);

    $query = Clientes::with('telefones', 'enderecos.estado');

    if (isset($data['administrador_id'])) {
      $query->where('administrador_id', $admin->value);
    } else {
      $query->whereNull('administrador_id')
        ->orWhere('administrador_id', 0);
    }

    return $query->get();
  }

  private function filtrarNotas($data)
  {
    $query = NotasFiscais::with('orcamento.cliente');

    $dataInicial = Carbon::now()->endOfMonth();
    $dataFinal = Carbon::now()->subMonths(6)->firstOfMonth();

    if ($data['data_inicial']) {
      $dataInicial = new Carbon($data['data_inicial']);
    }
    if ($data['data_final']) {
      $dataFinal = new Carbon($data['data_final']);
    }
    $query->whereBetween('data_geracao', [$dataInicial, $dataFinal]);

    if (isset($data['cliente_id'])) {
      $query->whereHas('orcamento', function ($query) use ($data) {
        $query->where('cliente_id', $data['cliente_id']);
      });
    }

    if (isset($data['tipo'])) {
      $query->where('tipo', $data['tipo']);
    }

    return $query->get();
  }

  private function filtrarNotasProjeto($data)
  {
    $dataInicial = Carbon::now()->endOfMonth();
    $dataFinal = Carbon::now()->subMonths(6)->firstOfMonth();

    if ($data['data_inicial']) {
      $dataInicial = new Carbon($data['data_inicial']);
    }
    if ($data['data_final']) {
      $dataFinal = new Carbon($data['data_final']);
    }
    $query = NotasProjetos::whereBetween('data_emissao', [$dataInicial, $dataFinal]);

    return $query->get();
  }

  private function filtrarClientes()
  {
    $query = Clientes::with(
      [
        'administrador',
        'enderecos',
        'ultimoOrcamento' => function ($query) {
          $query
            ->with(['ultimaOS']);
        }
      ])
      ->select(['razao_social', 'id'])->orderBy('razao_social');

    return $query->get();
  }

  private function filtrarFluxoCaixa($data)
  {
    $result = [];

    $dataInicial = Carbon::now()->endOfMonth();
    $dataFinal = Carbon::now()->subMonths(6)->firstOfMonth();
    if ($data['dataInicialAno'] && $data['dataInicialMes']) {
      $dataInicial = (new Carbon())->setDate((int) $data['dataInicialAno'], (int) $data['dataInicialMes'], 1)->startOfMonth();
    }
    if ($data['dataFinalAno'] && $data['dataFinalMes']) {
      $dataFinal = (new Carbon())->setDate((int) $data['dataFinalAno'], (int) $data['dataFinalMes'], 1)->endOfMonth();
    }

    $contasReceber = ContasReceber::whereBetween('data_pagamento', [$dataInicial, $dataFinal])
      ->select(
        DB::raw('YEAR(data_pagamento) AS ano'),
        DB::raw('MONTH(data_pagamento) as mes'),
        DB::raw('SUM(valor_pago) AS soma'),
        DB::raw('SUM(valor_retido) AS soma_retido')
      )
      ->groupBy('ano', 'mes');
    $contasReceberDetalhamento = ContasReceber::whereBetween('data_pagamento', [$dataInicial, $dataFinal]);

    $contasPagar = ContasPagar::whereBetween('data_pagamento', [$dataInicial, $dataFinal])
      ->select(
        DB::raw('YEAR(data_pagamento) AS ano'),
        DB::raw('MONTH(data_pagamento) as mes'),
        DB::raw('SUM(valor_pago) AS soma')
      )
      ->groupBy('ano', 'mes');
    $contasPagarDetalhamento = ContasPagar::whereBetween('data_pagamento', [$dataInicial, $dataFinal]);

    if (isset($data['empresa_id'])) {
      $contasReceber->whereIn('empresa_id', $data['empresa_id']);
      $contasPagar->whereIn('empresa_id', $data['empresa_id']);
      $contasReceberDetalhamento->whereIn('empresa_id', $data['empresa_id']);
      $contasPagarDetalhamento->whereIn('empresa_id', $data['empresa_id']);
    }

    $contasReceber = $contasReceber->get();
    $contasPagar = $contasPagar->get();

    if ($contasReceber->isNotEmpty() && $contasPagar->isNotEmpty()) {
      $fluxo = [];
      $fluxos = [];
      $totais = [
        'Recebido' => 0,
        'Pago' => 0,
        'Saldo' => 0
      ];
      foreach ($contasReceber AS $conta) {
        $fluxo[$conta->ano . $conta->mes] = [
          'date' => $conta->mes . '/' . $conta->ano,
          'Recebido' => $conta->soma,
          'Pago' => 0,
          'Saldo' => $conta->soma
        ];
      }

      foreach ($contasPagar AS $conta) {
        $fluxo[$conta->ano . $conta->mes] = [
          'date' => $conta->mes . '/' . $conta->ano,
          'Recebido' => $fluxo[$conta->ano . $conta->mes]['Recebido'] ?? 0,
          'Pago' => $conta->soma,
          'Saldo' => ($fluxo[$conta->ano . $conta->mes]['Saldo'] ?? 0) - $conta->soma
        ];
        $fluxos[] = $fluxo[$conta->ano . $conta->mes];

        $totais['Recebido'] += $fluxo[$conta->ano . $conta->mes]['Recebido'];
        $totais['Pago'] += $fluxo[$conta->ano . $conta->mes]['Pago'];
        $totais['Saldo'] += $fluxo[$conta->ano . $conta->mes]['Saldo'];
      }
      $result['fluxoTotais'] = $totais;
      $result['fluxo'] = $fluxos;
    }

    $contasReceberDetalhamento = $contasReceberDetalhamento->get();
    $detalhamentoContasReceber = [];
    foreach ($contasReceberDetalhamento AS $conta) {
      if (!isset($detalhamentoContasReceber[str_slug($conta->orcamento->cliente->categoria->categoria)])) {
        $detalhamentoContasReceber[str_slug($conta->orcamento->cliente->categoria->categoria)]['total'] = 0;
      }
      $detalhamentoContasReceber[str_slug($conta->orcamento->cliente->categoria->categoria)]['total'] += $conta->valor_pago;
      $detalhamentoContasReceber[str_slug($conta->orcamento->cliente->categoria->categoria)]['categoria'] = $conta->orcamento->cliente->categoria->categoria;
    }
    foreach ($detalhamentoContasReceber AS $index => $conta) {
      $detalhamentoContasReceber[] = $conta;
      unset($detalhamentoContasReceber[$index]);
    }
    $result['detalhamentoContasReceber'] = $detalhamentoContasReceber;

    $contasPagarDetalhamento = $contasPagarDetalhamento->get();
    $detalhamentoContasPagar = [];
    foreach ($contasPagarDetalhamento AS $conta) {
      if (!isset($detalhamentoContasPagar[str_slug($conta->categoria->categoria)])) {
        $detalhamentoContasPagar[str_slug($conta->categoria->categoria)]['total'] = 0;
      }
      $detalhamentoContasPagar[str_slug($conta->categoria->categoria)]['total'] += $conta->valor_pago;
      $detalhamentoContasPagar[str_slug($conta->categoria->categoria)]['categoria'] = $conta->categoria->categoria;
    }
    foreach ($detalhamentoContasPagar AS $index => $conta) {
      $detalhamentoContasPagar[] = $conta;
      unset($detalhamentoContasPagar[$index]);
    }
    $result['detalhamentoContasPagar'] = $detalhamentoContasPagar;

    return $result;
  }

  private function filtrarOrdemServico($data)
  {
    $query = OrdensServico::with('orcamento.cliente', 'empresa', 'mtrs.certificados');

    $dataInicial = Carbon::now()->endOfMonth();
    $dataFinal = Carbon::now()->subMonths(6)->firstOfMonth();

    if (isset($data['data_inicial'])) {
      $dataInicial = new Carbon($data['data_inicial']);
    }
    if (isset($data['data_final'])) {
      $dataFinal = new Carbon($data['data_final']);
    }
    $query->whereBetween('data_coleta', [$dataInicial, $dataFinal]);

    if ($data['status']) {
      $query->where('status', $data['status']);
    }

    if ($data['empresa_id']) {
      $query->where('empresa_id', $data['empresa_id']);
    }

    if ($data['cliente_id']) {
      $query->whereHas('orcamento', function ($query) use ($data) {
        $query->where('cliente_id', $data['cliente_id']);
      });
    }

    return $query->get();
  }
}
