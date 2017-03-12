<?php

class Erp_RelatorioCteController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Ctes_Model();
        parent::init();
        $this->model->_title = 'Relatório de CT-e';
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
                //$data = Erp_Date::dateLimit($data, 60, 'data_inicial');
            endif;

            $items = $this->model->relatorio($data);

            if ($data['gera_csv']):
                $linhas = array();
                $total_pago = 0;
                $total_gerado = 0;
                $linhas[] = 'CTE;Cliente;Data de Emissão;Valor';
                foreach ($items AS $item):
                    $retorno = array();
                    $dados = $this->model->adjustToView($item);
                    $retorno['id'] = $dados['id'];
                    $retorno['cliente'] = $dados['cliente'];
                    $retorno['data'] = $dados['data'];
                    $retorno['valor'] = $dados['total'];
                    $linhas[] = implode(';', $retorno);
                    $total += $item['total'];
                endforeach;
                $linhas[] = ';;Total Gerado;' . WS_Money::adjustToView($total);
                $WF = new WS_File();
                $file = 'cte-'.date('U').'.csv';
                $arquivo = UPLOAD_PATH . '/relatorios/' . $file;
                $WF->create($arquivo, $linhas);
                $this->view->csv = $file;
            endif;

            $this->view->items = $items;
        endif;
        $this->view->data = $data;
    }

    public function zipaarquivosAction() {
        $ids = $this->_getParam('cte_id');
        $arquivos = array();
        foreach ($ids AS $id):
            $CteModel = new Ctes_Model();
            $item = $CteModel->find($id);

            $arquivo = UPLOAD_PATH . 'cte/xml/' . $item['codigo'] . '-proc.xml';
            if (is_file($arquivo)):
                $arquivos[] = $arquivo;
            endif;

            $arquivo = UPLOAD_PATH . 'cte/pdf/' . $item['codigo'] . '.pdf';
            if (is_file($arquivo)):
                $arquivos[] = $arquivo;
            endif;

        endforeach;
        if (!empty($arquivos)):
            $WSFile = new WS_File();
            $data = date('U');
            $WSFile->create_zip($arquivos, UPLOAD_PATH . 'cte/relatorio_contador-'.$data.'.zip', true);
            echo '<a href="/storage/file/relatorio_contador-'.$data.'.zip/cte/save" class="botao" target="_blank">Download do Arquivo</a>';
        else:
            echo '<div class="error">Nenhum arquivo encontrado!</div>';
        endif;
        exit();
    }

}
