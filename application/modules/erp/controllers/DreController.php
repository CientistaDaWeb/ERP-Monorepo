<?php

class Erp_DreController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ContasReceber_Model();
        parent::init();
        $this->model->_title = 'Demonstrativo de Resultado';
    }

    public function indexAction() {
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, 1, date('Y')));
        $data['data_final'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, 31, date('Y')));
        $data['empresa_id'] = '';
        $data['gera_csv'] = '';

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();
            $ContasPagarModel = new ContasPagar_Model();
            $ContasReceberModel = new ContasReceber_Model();
            $BensModel = new Bens_Model();
            $NotasFiscaisModel = new NotasFiscais_Model();
            $CtesModel = new Ctes_Model();
            $CtesAcqualifeModel = new CtesAcqualife_Model();

            $dataInicial = WS_Date::adjustToDb($data['data_inicial']);
            $dataFinal = WS_Date::adjustToDb($data['data_final']);


            if (!empty($dataInicial) || !empty($dataFinal)):
                //$faturamento = $ContasReceberModel->getBillingByPeriod($dataInicial, $dataFinal);
                $faturamento = $NotasFiscaisModel->getSumByPeriod($dataInicial, $dataFinal, $data['empresa_id']);
                $data['faturamento'] = $data['faturamento_notas'] = $faturamento['faturamento'];

                $faturamentoCte = $CtesModel->getSumByPeriod($dataInicial, $dataFinal, $data['empresa_id']);
                $data['faturamento_ctes'] = $faturamentoCte['faturamento'];
                $data['faturamento'] += $faturamentoCte['faturamento'];

                $faturamentoCteAcqualife = $CtesAcqualifeModel->getSumByPeriod($dataInicial, $dataFinal, $data['empresa_id']);
                $data['faturamento_ctes_acqualife'] = $faturamentoCteAcqualife['faturamento'];
                $data['faturamento'] += $faturamentoCteAcqualife['faturamento'];

                $inicio = new Zend_Date($dataInicial);
                $inicio->sub(1, Zend_Date::MONTH);

                $investimentosInicial = $BensModel->getByPeriod($dataInicial, $inicio->__toString('YYYY-MM-dd'));
                $investimentosFinal = $BensModel->getByPeriod($dataFinal, $inicio->__toString('YYYY-MM-dd'));

//                var_dump($investimentosInicial);
//                var_dump($investimentosFinal);

                $data['depreciacao'] = $investimentosFinal - $investimentosInicial;

                $custo_fixo = $ContasPagarModel->getSumByPeriod($dataInicial, $dataFinal, '1', true, $data['empresa_id']);
                $custo_variavel = $ContasPagarModel->getSumByPeriod($dataInicial, $dataFinal, '2', true, $data['empresa_id']);

                $despesasCategoria = $ContasPagarModel->getSumByPeriodCategory($dataInicial, $dataFinal, NULL, $data['empresa_id']);

                $valor_retido = $ContasReceberModel->getRetainedByPeriod($dataInicial, $dataFinal, $data['empresa_id']);

                $data['custo_fixo'] = $custo_fixo['custo'];
                $data['custo_variavel'] = $custo_variavel['custo'];
                $data['valor_retido'] = $valor_retido['retido'];
                $data['investimentos'] = $investimentosFinal;
                $data['despesasCategoria'] = $despesasCategoria;
                $data['contasReceber'] = $ContasReceberModel->getExtractBillingByPeriod($dataInicial, $dataFinal);

                $dados = array(
                    'data_inicial' => $data['data_inicial'],
                    'data_final' => $data['data_final']
                );
                $dados2 = array(
                    'data_inicial_lancamento' => $data['data_inicial'],
                    'data_final_lancamento' => $data['data_final']
                );

                $data['notasFiscais'] = $NotasFiscaisModel->relatorio($dados);
                $data['contasPagar'] = $ContasPagarModel->Relatorio($dados2);

                if ($data['gera_csv']):

                    $item = $data;
                    $contribuicao = $item['faturamento'] - $item['custo_variavel'] - $item['valor_retido'];
                    $item['depreciacao'] = -1 * $item['depreciacao'];
                    $lucroOperacional = $contribuicao - $item['custo_fixo'];
                    $saldo = $lucroOperacional - $item['depreciacao'];

                    if (!empty($this->data['bens'])):
                        $BensModel = new Bens_Model();
                        $total = array('compra' => 0, 'atual' => 0, 'depreciado' => 0, 'depreciacao' => 0);
                        foreach ($this->data['bens'] AS $investimento):
                            $investimento = $BensModel->adjustToView($investimento, WS_Date::adjustToDb($this->data['data_final']), WS_Date::adjustToDb($this->data['data_inicial']));
                            $total['compra'] += $investimento['valor_compra'];
                            $total['depreciado'] += $investimento['valor_depreciado'];
                            $total['atual'] += $investimento['valor_atual'];
                            if ($investimento['meses'] == $investimento['meses_quitacao']):
                                $investimento['depreciacao'] = 0;
                            endif;
                            $total['depreciacao'] += $investimento['depreciacao'];
                        endforeach;
                        $perc = array('atual' => 0, 'recuperar' => 0);
                        $perc['atual'] = (100 * $total['atual']) / $total['compra'];
                        $perc['recuperar'] = 100 - $perc['atual'];

                        $item['depreciacao'] = $total['depreciacao'];
                        $saldo = $lucroOperacional - $total['depreciacao'];
                    endif;

                    $linhas = array();
                    //$linhas[] = 'Demonstrativo de resultado do Período ('.$data['data_inicial'].' - '.$data['data_final'].')';
                    $linhas[] = ';Discriminação;Valor;%';
                    $linhas[] = '1;Faturamento;' . WS_Money::adjustToView($data['faturamento']) . '(CTE: ' . WS_Money::adjustToView($data['faturamento_ctes']) . ' | CTE Aqualife: '. WS_Money::adjustToView($data['faturamento_ctes_acqualife']) .' | Notas: ' . WS_Money::adjustToView($data['faturamento_notas']) . ');100%';
                    $linhas[] = '2;Retenção de Impostos;' . WS_Money::adjustToView($data['valor_retido']) . ';' . number_format($data['valor_retido'] * 100 / $data['faturamento'], 2, ',', '.') . '%';
                    $linhas[] = '3;Custo Variável;' . WS_Money::adjustToView($item['custo_variavel']) . ';' . number_format($data['custo_variavel'] * 100 / $data['faturamento'], 2, ',', '.') . '%';
                    $linhas[] = '4;Margem de Contribuição(1-2-3);' . WS_Money::adjustToView($contribuicao) . ';' . number_format($contribuicao * 100 / $item['faturamento'], 2, ',', '.') . '%';
                    $linhas[] = '5;Custo Fixo;' . WS_Money::adjustToView($item['custo_fixo']) . ';' . number_format($item['custo_fixo'] * 100 / $item['faturamento'], 2, ',', '.') . '%';
                    $linhas[] = '6;Lucro Operacional(4-5);' . WS_Money::adjustToView($lucroOperacional) . ';' . number_format($lucroOperacional * 100 / $item['faturamento'], 2, ',', '.') . '%';
                    $linhas[] = '7;Depreciação no Período;' . WS_Money::adjustToView($item['depreciacao']) . ';' . number_format($item['depreciacao'] * 100 / $item['faturamento'], 2, ',', '.') . '%';
                    $linhas[] = '8;Lucro Líquido (6-7);' . WS_Money::adjustToView($saldo) . ';' . number_format($saldo * 100 / $item['faturamento'], 2, ',', '.') . '%';

                    if (!empty($data['bens'])):
                        $linhas[] = '';
                        $linhas[] = '';
                        $linhas[] = 'Investimentos';
                        $linhas[] = 'Investimento Total;' . WS_Money::adjustToView($total['compra']) . ';100%';
                        $linhas[] = 'Investimento a Recuperar;' . WS_Money::adjustToView($total['atual']) . ';' . number_format($perc['atual'], 2, ',', '.') . '%';
                        $linhas[] = 'Retorno do Investimento;' . WS_Money::adjustToView($total['depreciado']) . ';' . number_format($perc['recuperar'], 2, ',', '.') . '%';
                    endif;

                    $linhas[] = '';
                    $linhas[] = '';
                    $linhas[] = 'Categorias de Contas';
                    $linhas[] = 'Categoria;Total;% Faturamento';
                    $total = array('custo' => 0, 'porcentagem' => 0);
                    foreach ($item['despesasCategoria'] AS $categoria):
                        $porcentagem = number_format($categoria['total'] * 100 / $item['faturamento'], 2, ',', '.');
                        $total['custo'] += $categoria['total'];
                        $total['porcentagem'] += $categoria['total'] * 100 / $item['faturamento'];
                        $linhas[] = $categoria['categoria'] . ';' . WS_Money::adjustToView($categoria['total']) . ';' . $porcentagem . '%';
                    endforeach;
                    $linhas[] = 'Total;' . WS_Money::adjustToView($total['custo']) . ';' . number_format($total['porcentagem'], 2, ',', '.') . '%';

                    $WF = new WS_File();
                    $file = 'dre.csv';
                    $arquivo = UPLOAD_PATH . '/' . $file;
                    $WF->create($arquivo, $linhas);
                    $this->view->csv = $file;
                endif;

            endif;
        endif;
        $this->view->data = $data;
    }

}
