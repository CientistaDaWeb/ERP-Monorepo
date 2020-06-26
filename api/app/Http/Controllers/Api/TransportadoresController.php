<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TransportadoresController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = [];

  public function __construct(\App\Models\Transportadores $model)
  {
    $this->model = $model;
  }
}
