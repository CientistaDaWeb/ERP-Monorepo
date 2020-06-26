<?php

class Erp_ProjetosAtividadesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ProjetosAtividades_Model();
        if ($this->_hasParam('parent_id')):
            $projeto_id = $this->_getParam('parent_id');
            $this->model->_formFields['projeto_id']['value'] = $projeto_id;
        endif;
        $this->form = WS_Form_Generator::generateForm('ProjetosAtividades', $this->model->getFormFields());
        parent::init();
    }

    public function projetoAction() {
        $projeto_id = $this->_getParam('parent_id');
        $items = $this->model->getByProject($projeto_id);
        $this->view->items = $items;
        $this->view->data['parent_id'] = $projeto_id;
    }

    public function formularioAction() {
        $projeto_id = $this->_getParam('parent_id');
        if (!empty($projeto_id)):
            $this->model->_params['projeto_id'] = $projeto_id;
            $dados['projeto_id'] = $projeto_id;
        endif;

        if (isset($dados)):
            $this->form->populate($dados);
        endif;

        parent::formularioAction();
    }

    public function concluirAction() {
        $ids = $this->_getParam('atividade_id');
        Zend_Debug::dump($ids);
        try {
            $where = $this->model->_db->getAdapter()->quoteInto('id IN(?)', $ids);
            $atividade = null;
            $atividade['status'] = 'c';
            $this->model->_db->update($atividade, $where);
            $this->alerta('sucess', 'Atividades concluídas com sucesso!');
        } catch (Exception $e) {
            $this->alerta('error', $e->getMessage());
        }

        exit();
    }

    public function ajustaAction() {
        $this->model->ajusta();
        echo 'Finalizou o ajuste';
        exit();
    }

}
