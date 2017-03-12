<?php

class Erp_RelatorioOrdemServicoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new OrdensServico_Model();
        parent::init();
        $this->model->_title = 'Relatório de ' . $this->model->getOption('plural');
    }

    public function indexAction() {
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
        $data['data_final'] = date('d/m/Y');
        $data['status'] = '';
        $data['cliente_id'] = '';
        $data['empresa_id'] = '';

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            /* Limita a data final da pesquisa quando não for administrador */
            $auth = new WS_Auth('erp');
            $user = $auth->getIdentity();
            if ($user->papel != 'A'):
                /* Limita a data inicial */
                $data = Erp_Date::dateLimit($data, 45, 'data_inicial');
            endif;

            $items = $this->model->relatorio($data);
            $this->view->items = $items;

            if ($data['gera_csv']):
                $linhas = array();
                $linhas[] = 'Status;Código;Data de Coleta;Cliente;Empresa;Volume Doméstico;Vol Industrial;Transporte;Certificado';
                var_dump($items);
                foreach ($items AS $item):
                    $total_domestico += $item['volume_domestico'] = $this->model->volumeDomestico($item['id']);
                    $total_industrial += $item['volume_industrial'] = $this->model->volumeIndustrial($item['id']);
                    $total_transporte += $item['volume_transporte'] = $this->model->transporte($item['id']);
                    $retorno = array();

                    $retorno['status'] = $this->model->getOption('status', $item['status']);
                    $retorno['codigo'] = $item['orcamento_id'] . '.' . $item['sequencial'];
                    $retorno['data'] =  WS_Date::adjustToView($item['data_coleta']);
                    $retorno['cliente'] = $item['cliente'];
                    $retorno['empresa'] = $item['empresa'];
                    $retorno['voldom'] = number_format($item['volume_domestico'],2,',','');
                    $retorno['volind'] = number_format($item['volume_industrial'],2,',','');
                    $retorno['voltra'] = number_format($item['volume_transporte'],2,',','');
                    if($item['certificado_id']):
                        $retorno['cert'] = 'S';
                    else:
                        $retorno['cert'] = 'N';
                    endif;
                    $linhas[] = implode(';', $retorno);
                endforeach;
                $linhas[] = ';;;;Total;'.$total_domestico.';'.$total_industrial.';'.$total_transporte.';';
                $WF = new WS_File();
                $file = 'ordem-servico-'.date('U').'.csv';
                $arquivo = UPLOAD_PATH . '/relatorios/' . $file;
                $WF->create($arquivo, $linhas);
                $this->view->csv = $file;
            endif;
        endif;
        $this->view->data = $data;
    }

    public function pdfAction() {
        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            $document = $this->model->montaRelatorio($data, 'pdf');

            if ($document) :
                $this->getResponse()
                        ->setHeader('Content-Disposition', 'attachment; filename=Relatorio-de-Ordens-de-Servico.pdf')
                        ->setHeader('Content-type', 'application/x-pdf')
                        ->setBody($document);
            endif;
        endif;
    }

    public function xlsAction() {
        $data = $this->_getAllParams();
        $arquivo = $this->model->montaRelatorio($data, 'xls');
        $document = fopen($arquivo, 'r');

        $this->getResponse()
                ->setHeader('Content-Disposition', 'attachment; filename=Relatório-Fepan.csv')
                ->setHeader('Content-type', 'application/excel');
        readfile($arquivo);
    }

    public function impressaoAction() {
        $ids = $this->_getParam('os_id');

        foreach ($ids AS $id):
            $item = $this->model->find($id);
            $ServicosModel = new Servicos_Model();
            $item['servicos'] = $ServicosModel->buscarPorOrdemServico($id);
            $ClientesEnderecosModel = new ClientesEnderecos_Model();
            $item['enderecos'] = $ClientesEnderecosModel->buscarPorCliente($item['cliente_id']);
            $ClientesTelefonesModel = new ClientesTelefones_Model();
            $item['telefones'] = $ClientesTelefonesModel->buscarPorCliente($item['cliente_id']);

            $items[] = $item;
        endforeach;
        $this->view->noLogo = true;
        $this->view->items = $items;
    }

}