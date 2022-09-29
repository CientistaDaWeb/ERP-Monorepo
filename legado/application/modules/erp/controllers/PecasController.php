<?php

class Erp_PecasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Pecas_Model();
        $this->form = WS_Form_Generator::generateForm('Pecas', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

    public function manutencaocaminhaoAction() {
        $manutencao_id = $this->_getParam('parent_id');
        $this->view->pecas = Pecas_Model::fetchPair();

        $ManutencaoCaminhaoPecasModel = new ManutencaoCaminhaoPecas_Model();
        $manutencaoPecas = $ManutencaoCaminhaoPecasModel->getByManutencao($manutencao_id);
        $this->view->pecasManutencao = $manutencaoPecas;
    }

    public function buscapecaAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);
        if (!empty($item)) {
            $this->view->item = $item;
        }
    }

    public function addmanutencaoAction() {
        $manutencao_id = $this->_getParam('parent_id');

        if ($this->_request->isPost()):
            $ManutencaoCaminhaoPecasModel = new ManutencaoCaminhaoPecas_Model();
            $ManutencaoCaminhaoPecasModel->limpaManutencao($manutencao_id);

            $data = $this->_request->getPost();
            try {
                foreach ($data['peca'] AS $peca) {
                    $dados['manutencao_id'] = $manutencao_id;
                    $dados['peca_id'] = $peca['peca_id'];
                    $dados['qtde'] = $peca['qtde'];
                    $dados['valor'] = $peca['valor'];
                    $dados['created'] = date('Y-m-d H:i:s');
                    $ManutencaoCaminhaoPecasModel->addPeca($dados);
                    $dados = null;
                }
                $this->alerta('sucess', 'Peças adicionadas com sucesso.');
            } catch (Exception $e) {
                $this->alerta('error', $e->getMessage());
            }

        endif;
    }

}
