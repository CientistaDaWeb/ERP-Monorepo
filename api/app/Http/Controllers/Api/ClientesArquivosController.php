<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientesArquivosController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['cliente'];

  public function __construct(\App\Models\ClientesArquivos $model)
  {
    $this->model = $model;
  }

  public function upload(Request $request)
  {
    $inputs = $request->all();
    $item = Clientes::findOrFail($inputs['cliente_id']);
    $arquivo = $request->file('file')->store('clientes-arquivos/');
    Storage::setVisibility($arquivo, 'public');
    $data= [
      'cliente_id' => $inputs['cliente_id'],
      'arquivo' => $arquivo,
      'descricao' => $inputs['descricao']
    ];
    $item = $this->model->create($data);
    return response()->json($item);
  }
}
