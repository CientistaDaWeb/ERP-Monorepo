<?php

class Erp_RelatorioNotasFiscaisController extends Erp_Controller_Action {

    public function init() {
        $this->model = new NotasFiscais_Model();
        parent::init();
        $this->model->_title = 'Relatório de Notas Fiscais';
    }

    public function indexAction() {
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
        $data['data_final'] = date('d/m/Y');
        $data['empresa_id'] = '';
        $data['tipo'] = '';
        $data['cliente_id'] = '';
        $data['gera_csv'] = '';

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            /* Limita a data final da pesquisa quando não for administrador */
            $auth = new WS_Auth('erp');
            $user = $auth->getIdentity();
            if ($user->papel != 'A'):
                /* Limita a data inicial */
                $data = Erp_Date::dateLimit($data, 35, 'data_inicial');
            endif;

            $items = $this->model->relatorio($data);

            if ($data['gera_csv']):
                $linhas = array();
                $total_pago = 0;
                $total_gerado = 0;
                $linhas[] = 'Número;Cliente;Orçamento;Data de Emissão;Valor;Tipo;Valor Retido';
                foreach ($items AS $item):
                    $retorno = array();
                    $dados = $this->model->adjustToView($item);
                    $retorno['numero'] = $dados['numero'];
                    $retorno['cliente'] = $dados['cliente'];
                    $retorno['orcamento'] = $dados['orcamento_id'];
                    $retorno['data_emissao'] = $dados['data_geracao'];
                    $retorno['valor'] = $dados['valor'];
                    $retorno['tipo'] = $dados['tipo'];
                    $retorno['valor_retido'] = $dados['valor_retido'];
                    $linhas[] = implode(';', $retorno);
                    $total += $item['valor'];
                    $total_retido += $item['valor_retido'];
                endforeach;
                $linhas[] = ';;;Total Gerado;' . WS_Money::adjustToView($total) . ';Total Retido;' . WS_Money::adjustToView($total_retido);
                $WF = new WS_File();
                $file = 'notas_fiscais.csv';
                $arquivo = UPLOAD_PATH . '/' . $file;
                $WF->create($arquivo, $linhas);
                $this->view->csv = $file;
            endif;

            $this->view->items = $items;
        endif;
        $this->view->data = $data;
    }

}
