<?php

class Erp_ProjetosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Projetos_Model();
        $this->form = WS_Form_Generator::generateForm('Projetos', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        $this->options['noList'] = true;
        parent::formularioAction();

        if (empty($this->view->data['prioridade'])):
            $this->model->_params['prioridade'] = 'N';
        endif;
    }

}
