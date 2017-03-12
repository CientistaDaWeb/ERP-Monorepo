<?php

class Erp_FluxoDeCaixaController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ContasReceber_Model();
        parent::init();
        $this->model->_title = 'Relatório de Fluxo de Caixa';
    }

    public function indexAction() {
        $ContasPagarModel = new ContasPagar_Model();
        $ContasReceberModel = new ContasReceber_Model();
        $data['empresa_id'] = '';
        $data['gera_csv'] = '';
        $data['empresa_id'] = array();

        if (empty($data['dataInicial']['mes'])):
            $seisMeses = mktime(0, 0, 0, date('m') - 6, date('d'), date('Y'));
            $data['dataInicial']['mes'] = date('m', $seisMeses);
            $data['dataInicial']['ano'] = date('Y', $seisMeses);
        endif;
        if (empty($data['dataFinal']['mes'])):
            $data['dataFinal']['mes'] = date('m');
            $data['dataFinal']['ano'] = date('Y');
        endif;


        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            $dataInicial = $data['dataInicial'];
            $dataFinal = $data['dataFinal'];

            if (!empty($dataInicial) || !empty($dataFinal)):
                $dataInicial['dia'] = '01';
                $dataFinal['dia'] = '31';

                $dataInicial = $dataInicial['ano'] . '-' . $dataInicial['mes'] . '-' . $dataInicial['dia'];
                $dataFinal = $dataFinal['ano'] . '-' . $dataFinal['mes'] . '-' . $dataFinal['dia'];
            endif;

            $contasReceber = $ContasReceberModel->buscarPorPeriodo($dataInicial, $dataFinal, $data['empresa_id']);
            $contasPagar = $ContasPagarModel->buscarPorPeriodo($dataInicial, $dataFinal, $data['empresa_id']);

            if (!empty($contasReceber) || !empty($contasPagar)):

                $contasCategorizadas = $ContasPagarModel->buscarPorCategoria($dataInicial, $dataFinal, $data['empresa_id']);
                $contasReceberCategorizadas = $ContasReceberModel->buscarPorCategoria($dataInicial, $dataFinal, '', $data['empresa_id']);

                $contasReceber = $ContasReceberModel->ajusteFluxo($contasReceber);
                $contasPagar = $ContasPagarModel->ajusteFluxo($contasPagar);

                if (!empty($contasReceber)):
                    if(!empty($contasPagar)):
                        $contas = array_merge_recursive($contasReceber, $contasPagar);
                    else:
                        $contas = $contasReceber;
                    endif;
                else:
                    $contas = $contasPagar;
                endif;

                $acumulado = array('pagar' => 0, 'receber' => 0, 'total' => 0);

                $acumulado['receber'] = $ContasReceberModel->buscarAcumulado($dataInicial, $data['empresa_id']);
                $acumulado['pagar'] = $ContasPagarModel->buscarAcumulado($dataInicial, $data['empresa_id']);
                $acumulado['total'] = $acumulado['receber']['soma'] - $acumulado['pagar']['soma'];
                $saldoAcumulado = $acumulado['total'];

                ksort($contas);
                $contasAjustadas = array();
                foreach ($contas AS $key => $conta):
                    $ZD = new Zend_Date($key . '-01');
                    if (!isset($conta['contas_pagar'])):
                        $conta['contas_pagar'] = 0;
                    endif;
                    if (!isset($conta['contas_receber'])):
                        $conta['contas_receber'] = 0;
                    endif;
                    $conta['saldo'] = $conta['contas_receber'] - $conta['contas_pagar'];
                    $conta['legenda'] = $ZD->toString('MM/yyyy');
                    $acumulado['total'] += $conta['saldo'];
                    $conta['acumulado'] = $acumulado['total'];
                    $contasAjustadas[$key] = $conta;
                endforeach;

                if ($data['gera_csv']):
                    $linhas = array();
                    $linhas[] = 'Mês/Ano;Recebido;Pago;Saldo';
                    $total = array('recebido' => 0, 'pago' => 0, 'saldo' => 0);
                    foreach ($contasAjustadas AS $conta):
                        $saldo = $conta['contas_receber'] - $conta['contas_pagar'];
                        $total['recebido'] += $conta['contas_receber'];
                        $total['pago'] += $conta['contas_pagar'];
                        $total['saldo'] += $conta['saldo'];
                        $linhas[] = $conta['legenda'] . ';' . WS_Money::adjustToView($conta['contas_receber']) . ';' . WS_Money::adjustToView($conta['contas_pagar']) . ';' . WS_Money::adjustToView($conta['saldo']);
                    endforeach;
                    $linhas[] = 'Total;' . WS_Money::adjustToView($total['recebido']) . ';' . WS_Money::adjustToView($total['pago']) . ';' . WS_Money::adjustToView($total['saldo']);
                    $tot = $total;
                    if (!empty($contasReceberCategorizadas)):

                        $linhas[] = 'Contas a Receber - Detalhamento por categoria';
                        $linhas[] = 'Categoria de Cliente;% do Recebido;Recebido (' . WS_Money::adjustToView($tot['recebido']) . ')';
                        foreach ($contasReceberCategorizadas AS $conta):
                            $porcentagem = $conta['total'] * 100 / $tot['recebido'];
                            $linhas[] = $conta['categoria'] . ';' . WS_Money::adjustToDb($porcentagem) . '%;' . WS_Money::adjustToView($conta['total']);
                        endforeach;

                    endif;
                    if (!empty($contasCategorizadas)):
                        $linhas[] = '';
                        $linhas[] = '';
                        $linhas[] = 'Contas a Pagar - Detalhamento por categoria';
                        $linhas[] = 'Categoria de Conta;% do Pago;Pago (' . WS_Money::adjustToView($tot['pago']) . ')';
                        foreach ($contasCategorizadas AS $conta):
                            $porcentagem = $conta['total'] * 100 / $tot['pago'];
                            $linhas[] = $conta['categoria'] . ';' . WS_Money::adjustToDb($porcentagem) . '%;' . WS_Money::adjustToView($conta['total']);
                        endforeach;
                    endif;
                    $WF = new WS_File();
                    $file = 'fluxo_caixa-'.date('U').'.csv';
                    $arquivo = UPLOAD_PATH . '/relatorios/' . $file;
                    $WF->create($arquivo, $linhas);
                    $this->view->csv = $file;
                endif;
                $this->view->contas = $contasAjustadas;
                $this->view->contasCategorizadas = $contasCategorizadas;
                $this->view->contasReceberCategorizadas = $contasReceberCategorizadas;
                $this->view->saldoAcumulado = $saldoAcumulado;
            endif;
        endif;
        $this->view->data = $data;
    }

}
