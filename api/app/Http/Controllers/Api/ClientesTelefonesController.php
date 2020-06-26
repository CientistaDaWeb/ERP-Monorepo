<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ClientesTelefonesController extends Controller
{
  use \App\Http\Controllers\ApiControllerTrait;

  protected $model;

  protected $relationships = ['categoria'];

  public function __construct(\App\Models\ClientesTelefones $model)
  {
    $this->model = $model;
  }
}
