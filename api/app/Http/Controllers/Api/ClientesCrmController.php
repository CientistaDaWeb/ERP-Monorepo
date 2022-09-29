<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ClientesCrmController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['usuario', 'cliente'];

  public function __construct(\App\Models\ClientesCrm $model)
  {
    $this->model = $model;
  }

  public function abertos(){
    $data = Carbon::today()->endOfDay()->addDay(15);

    $result = $this->model
      ->with('cliente')
      ->with('usuario')
      ->where('status', 'A')
      ->where('data', '<=', $data)
      ->get()
    ;

    return response()->json($result);
  }
}
