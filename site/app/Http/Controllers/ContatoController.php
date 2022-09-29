<?php

namespace App\Http\Controllers;

use App\Mail\Contato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    public function send(Request $request)
    {
        try {
            Mail::send(new Contato([
                'nome' => $request->input('nome'),
                'email' => $request->input('email'),
                'telefone' => $request->input('telefone'),
                'cidade' => $request->input('cidade'),
                'mensagem' => $request->input('mensagem')

            ]));
            return redirect()->back()->with('success', 'Mensagem enviada com sucesso!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Erro ao enviar o e-mail, nos contato por telefone!' . $exception->getMessage());
        }


    }
}
