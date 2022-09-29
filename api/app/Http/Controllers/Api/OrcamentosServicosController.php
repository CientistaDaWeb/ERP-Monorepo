<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Mail\OrcamentosServicos;
use App\Models\TextosCategorias;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\OrcamentosServicosVisualizar;

class OrcamentosServicosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['orcamento', 'servico.categoria'];

  public function __construct(\App\Models\OrcamentosServicos $model)
  {
    $this->model = $model;
  }

  public function email(Request $r)
  {
    try {
      $pdf = new OrcamentosServicosVisualizar($r->id);
      $destino = explode(',', $r->destinatarios);
      Mail::to($destino)
        ->send(new OrcamentosServicos($r->assunto, $r->descricao, $pdf->visualizar()));
      return ['erro' => false, 'msg' => 'E-mail enviado!!!'];
    } catch (\Exception $e) {
      return ['erro' => true, 'msg' => $e->getMessage()];
    }

  }

  public function pegaTextos()
  {
    try {
      $assuntos = TextosCategorias::with('textos')->where('categoria', '[E-mail] Assunto')->first();
      $descricao = TextosCategorias::with('textos')->where('categoria', '[E-mail] Descrição')->first();

      return ['erro' => 0, 'assuntos' => $assuntos, 'descricao' => $descricao];
    } catch (\Exception $e) {
      return ['erro' => 1, 'msg' => $e->getMessage()];
    }
  }

  public function visualizar($id)
  {
    $pdf = new OrcamentosServicosVisualizar($id);

    return ['erro' => 0, 'arq' => $pdf->visualizar()] ;
  }

  public function downloadPdf($arq)
  {
    if (file_exists($arq . '.pdf')) {
      return response()->download($arq . '.pdf', 'orcamento.pdf')->deleteFileAfterSend();
    } else {
      return response()->back();
    }
  }
}
