<?php

class Erp_ProjetosCrmController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ProjetosCrm_Model();
        $this->model->_buttons['convert'] = 'Converter em Compromisso';
        $this->form = WS_Form_Generator::generateForm('ProjetosCrm', $this->model->getFormFields());
        parent::init();
    }

    public function projetoAction() {
        $projeto_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorProjeto($projeto_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $projeto_id = $this->_getParam('parent_id');
        if (!empty($projeto_id)):
            $this->model->_params['projeto_id'] = $projeto_id;
        endif;

        $auth = new WS_Auth('erp');
        $usuario = $auth->getIdentity();
        if (!$this->_hasParam('usuario_id')):
            $this->model->_params['usuario_id'] = $usuario->id;
        endif;
        parent::formularioAction();
    }

}
