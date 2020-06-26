<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function Download($nome, $ext, $arq)
    {
     return response()->download($arq . '.' . $ext, $nome . '.' . $ext)
                      ->deleteFileAfterSend();
    }
}
