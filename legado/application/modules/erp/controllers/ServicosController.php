<?php

class Erp_ServicosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Servicos_Model();
        $this->form = new Servicos_Form();
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

    public function ordemservicoAction() {
        $ordem_servico_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorOrdemServico($ordem_servico_id);
        $this->view->items = $items;
    }

    public function addordemservicoAction() {
        $ordem_servico_id = $this->_getParam('parent_id');
        if ($this->_request->isPost()):
            $OrdemServicoServicosModel = new OrdensServicoServicos_Model();
            $OrdemServicoServicosModel->limpaServicos($ordem_servico_id);
            $data = $this->_request->getPost();

            $os['valor'] = 0;

            try {
                foreach ($data['servico'] AS $servico) {
                    $dados['ordem_servico_id'] = $ordem_servico_id;
                    $dados['servico_id'] = $servico['servico_id'];
                    $dados['qtde'] = $servico['qtde'];
                    $dados['valor'] = $servico['valor'];
                    $dados['created'] = date('Y-m-d H:i:s');
                    $OrdemServicoServicosModel->addServico($dados);
                    $dados = null;
                    $os['valor'] += $servico['qtde'] * $servico['valor'];
                }
                $this->alerta('sucess', 'Serviços adicionados a ordem de serviço.');
            } catch (Exception $e) {
                $this->alerta('error', $e->getMessage());
            }

            $OrdensServicoModel = new OrdensServico_Model();
            $where = $OrdensServicoModel->_db->getAdapter()->quoteInto('id = ?', $ordem_servico_id);
            $OrdensServicoModel->_db->update($os, $where);
        endif;
    }

    public function buscaservicoAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);
        if (!empty($item)) {
            $this->view->item = $item;
        }
    }

    public function orcamentoAction() {
        $orcamento_id = $this->_getParam('parent_id');

        $this->view->servicosOrcamento = $this->model->buscarPorOrcamento($orcamento_id);

        $this->model->setBasicSearch();
        $sql = clone($this->model->_basicSearch);
        $servicos = $sql->query()->fetchAll();
        $this->view->servicos = $servicos;
    }

    public function addorcamentoAction() {
        $orcamento_id = $this->_getParam('parent_id');

        if ($this->_request->isPost()):
            $OrcamentosServicos_Model = new OrcamentosServicos_Model();
            $OrcamentosServicos_Model->limpaServicos($orcamento_id);

            $data = $this->_request->getPost();
            try {
                foreach ($data['servico'] AS $servico) {
                    $dados['orcamento_id'] = $orcamento_id;
                    $dados['servico_id'] = $servico['servico_id'];
                    $dados['qtde'] = $servico['qtde'];
                    $dados['preco'] = $servico['valor'];
                    $dados['created'] = date('Y-m-d H:i:s');
                    $OrcamentosServicos_Model->addServico($dados);
                    $dados = null;
                }
                $this->alerta('sucess', 'Serviços adicionados ao orçamento.');
            } catch (Exception $e) {
                $this->alerta('error', $e->getMessage());
            }

        endif;
    }

}