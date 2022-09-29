<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrcamentosServicos extends Mailable
{
    use Queueable, SerializesModels;

    public $assunto;

    public $descricao;

    public $pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assunto, $descricao, $pdf)
    {
        $this->assunto = $assunto;
        $this->descricao = $descricao;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $descricao = $this->descricao;
        return $this->view('emails.orcamentosServicos', compact('descricao'))
                    ->attach($this->pdf . '.pdf', [
                        'as' => 'orcamento.pdf',
                        'mime' => 'application/pdf'
                    ]);
    }
}
