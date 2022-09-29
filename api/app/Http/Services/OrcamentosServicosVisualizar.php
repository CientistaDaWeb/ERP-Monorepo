<?php

namespace App\Http\Services;

use App\Models\Orcamentos;
use Codedge\Fpdf\Fpdf\Fpdf;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class OrcamentosServicosVisualizar
{
    private $orcamento;
    private $id;

    public function __construct($id = null)
    {
        if ($id) {
            $this->orcamento = Orcamentos::with(
                'empresa',
                'cliente',
                'usuario',
                'orcamentosServicos',
                'orcamentosServicos.servico',
                'orcamentosServicos.servico.categoria'
            )->find($id);
            $this->id = $id;
        }
    }

    public function visualizar()
    {
        // dd($this->orcamento->toArray());

        $userId = Auth::id();
        $data = Date('d/m/Y');

        /* REMOVE ARQUIVOS .PDF ANTIGOS DO USUÁRIO */
        $aArqs = array_slice(scandir($_SERVER['DOCUMENT_ROOT']), 2);
        foreach ($aArqs as $arq) {
            if (preg_match('/' . $userId . '_.*\.pdf/', $arq)) {
                unlink($arq);
            }
        }

        /* CRIA NOME DO .PDF */
        $faker = Faker::create();
        $arq = $userId . '_' . $faker->uuid;

        /* INICIO DO RELATÓRIO */
        $pdf = new Fpdf;
        $hL = 3.5;
        $pdf->AddPage('L');
        $pdf->SetFont('Courier', '', 8);
        $pdf->Cell(0,$hL, $this->conv($this->orcamento->empresa->razao_social), 0, 1, 'L');
        $pdf->Cell(0,$hL, $this->conv($this->orcamento->empresa->endereco) . ' ' . $this->orcamento->empresa->numero . ' ' . $this->conv($this->orcamento->empresa->complemento) . ' ' . $this->conv($this->orcamento->empresa->bairro), 0, 1, 'L');
        $pdf->Cell(0,$hL, $this->orcamento->empresa->cep . ' ' . $this->conv($this->orcamento->empresa->cidade) . '-' . $this->orcamento->empresa->estado->uf, 0, 1, 'L');
        $pdf->Cell(0,$hL, 'Fones: ' . $this->orcamento->empresa->telefone . ' ' . $this->orcamento->empresa->telefone2 . ' ' . $this->orcamento->empresa->telefone3, 0, 1, 'L');
        $pdf->Cell(0,$hL, 'Email: ' . $this->orcamento->empresa->email, 0, 1, 'L');
        $pdf->Cell(0,$hL, 'Website: ' . $this->orcamento->empresa->site, 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->Cell(0,$hL, $this->conv('Orçamento nº ' . $this->id), 0, 1, 'L');
        $pdf->SetY($pdf->GetY() - 4);
        $pdf->Cell(0,$hL, $data, 0, 1, 'R');
        $pdf->Ln(5);

        $pdf->MultiCell(0,$hL, $this->conv(str_replace("\n", ' ', $this->orcamento->titulo)), 0, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Courier', 'B', 8);
        $pdf->Cell(0,$hL, 'Cliente: ' . $this->conv($this->orcamento->cliente->razao_social), 0, 1, 'L');
        $pdf->SetFont('Courier', '', 8);
        $pdf->Cell(0,$hL, 'Contato: ' . $this->conv($this->orcamento->cliente->contato), 0, 1, 'L');
        $pdf->Cell(0,$hL, $this->conv('Conforme solicitado segue o orçamento para os trabalhos descritos abaixo:'), 0, 1, 'L');
        $pdf->Ln(5);

        $pdf->SetFont('Courier', 'B', 8);
        $pdf->SetFillColor(238, 238, 238);
        $pdf->Cell(15,$hL, $this->conv('Código'), 1, 0, 'C', 1);
        $pdf->Cell(220,$hL, $this->conv('Descrição'), 'TRB', 0, 'C', 1);
        $pdf->Cell(20,$hL, 'Qtd', 'TRB', 0, 'C', 1);
        $pdf->Cell(25,$hL, $this->conv('Valor Unitário'), 'TRB', 1, 'C', 1);
        $pdf->SetFont('Courier', '', 8);

        foreach ($this->orcamento->orcamentosServicos as $orcServ) {
            $gY = $pdf->GetY();
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(15,$hL, '', 0, 0, 'L');
            $pdf->MultiCell(220,$hL, $this->conv($orcServ->servico->categoria->categoria), 'R', 'L');
            $pdf->SetFont('Courier', '', 8);
            $pdf->Cell(15,$hL, '', 0, 0, 'L');
            $pdf->MultiCell(220,$hL, $this->conv($orcServ->servico->descricao), 'LRB', 'L');
            $h = $pdf->GetY() - $gY;
            $pdf->SetY($gY);
            $pdf->Cell(15, $h, $orcServ->servico->categoria->id, 'LRB', 0, 'C');
            $pdf->SetX($pdf->GetX() + 220);
            $pdf->Cell(20, $h, $this->num($orcServ->qtde) . ' ' . $this->conv($orcServ->servico->unidade), 'TRB', 0, 'L');
            $pdf->Cell(25, $h, 'R$ ' . $this->num($orcServ->preco), 'TRB', 1, 'R');
        }
        $pdf->Ln(5);

        $pdf->SetFont('Courier', 'B', 8);
        $pdf->Cell(0,$hL, $this->conv('Condições de Pagamento'), 0, 1, 'L');
        $pdf->SetFont('Courier', '', 8);
        $pdf->Cell(0,$hL, $this->conv($this->orcamento->condicoes_pagamento) . ' (Podendo ser parcelado)', 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->SetFont('Courier', 'B', 8);
        $pdf->Cell(0,$hL, 'Validade da Proposta', 0, 1, 'L');
        $pdf->SetFont('Courier', '', 8);
        $pdf->Cell(0,$hL, '- 30 Dias' . ' (Podendo ser parcelado)', 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->SetFont('Courier', 'B', 8);
        $pdf->Cell(0,$hL, $this->conv('Observações'), 0, 1, 'L');
        $pdf->SetFont('Courier', '', 8);
        $pdf->MultiCell(0,$hL, $this->conv($this->orcamento->observacoes), 0, 'L');
        $pdf->Ln(3);

        $pdf->Cell(0, $hL, $this->conv('Colocamo-nos a sua disposição para quaisquer esclarecimentos adicionais.'), 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->Cell(0,$hL, 'Atenciosamente,', 0, 1, 'L');
        $pdf->Cell(0,$hL, $this->orcamento->usuario->nome, 0, 1, 'L');
        $pdf->Cell(0,$hL, $this->orcamento->usuario->email, 0, 1, 'L');
        $pdf->Cell(0,$hL, $this->orcamento->usuario->telefone, 0, 1, 'L');

        $pdf->Output('F', $arq . '.pdf');

        return $arq;
    }

    private function conv($str)
    {
        return iconv('UTF-8', 'ISO-8859-1', $str);
    }

    private function num($num) {
        return number_format($num, 2, ',', '.');
    }
}