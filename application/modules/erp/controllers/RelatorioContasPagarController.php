<?php

class Erp_RelatorioContasPagarController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ContasPagar_Model();
        parent::init();
        $this->model->_title = 'Relatório de ' . $this->model->getOption('plural');
    }

    public function indexAction() {
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
        $data['data_final'] = date('d/m/Y');
        $data['data_inicial_pago'] = '';
        $data['data_final_pago'] = '';
        $data['data_inicial_lancamento'] = '';
        $data['data_final_lancamento'] = '';
        $data['status'] = '';
        $data['categoria_id'] = '';
        $data['fornecedor_categoria_id'] = '';
        $data['fornecedor_id'] = '';
        $data['forma_pagamento_id'] = '';
        $data['conta_fixa'] = '';
        $data['empresa_id'] = '';
        $data['ordem'] = '';
        $data['ordem_tipo'] = '';
        $data['gera_csv'] = '';

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            /* Limita a data final da pesquisa quando não for administrador */
            $auth = new WS_Auth('erp');
            $user = $auth->getIdentity();
            if ($user->papel != 'A'):
                /* Limita a data inicial */
                $data = Erp_Date::dateLimit($data, 35, 'data_inicial');
                /* Limita a data de Pagamento */
                $data = Erp_Date::dateLimit($data, 35, 'data_inicial_pago');
                /* Limita a data de Lancamento */
                $data = Erp_Date::dateLimit($data, 35, 'data_inicial_lancamento');
            endif;

            $items = $this->model->Relatorio($data);

            if ($data['gera_csv']):
                $linhas = array();
                $total_pago = 0;
                $total_gerado = 0;
                $linhas[] = 'Status;Data de lançamento;Data de Vencimento;Valor;Data de Pagamento;Valor Pago;Fornecedor;Cat. Conta;Empresa;Forma Pag.';
                foreach ($items AS $item):
                    $retorno = array();
                    $dados = $this->model->adjustToView($item);
                    $retorno['status'] = $dados['status'];
                    $retorno['data_lancamento'] = $dados['data_lancamento'];
                    $retorno['data_vencimento'] = $dados['data_vencimento'];
                    $retorno['valor'] = $dados['valor'];
                    $retorno['data_pagamento'] = $dados['data_pagamento'];
                    $retorno['valor_pago'] = $dados['valor_pago'];
                    $retorno['fornecedor'] = $dados['fornecedor'];
                    $retorno['categoria'] = $dados['categoria'];
                    $retorno['empresa'] = $dados['empresa'];
                    $retorno['forma_pagamento'] = $dados['forma_pagamento'];
                    $linhas[] = implode(';', $retorno);
                    $total_pago += $item['valor_pago'];
                    $total_gerado += $item['valor'];
                endforeach;
                $linhas[] = ';;Total Gerado;' . WS_Money::adjustToView($total_gerado) . ';Total Pago;' . WS_Money::adjustToView($total_pago) . ';;;;';
                $WF = new WS_File();
                $file = 'contas_pagar-'.date('U').'.csv';
                $arquivo = UPLOAD_PATH . '/relatorios/' . $file;
                $WF->create($arquivo, $linhas);
                $this->view->csv = $file;
            endif;

            $this->view->items = $items;
        endif;
        $this->view->data = $data;
    }

}
