<?php

class Erp_AuthController extends Erp_Controller_Action {

    public function indexAction() {
        $this->model = new Auth_Model();
        $form = WS_Form_Generator::generateForm('Login', $this->model->getFormFields());

        if ($this->_request->isPost()) :
            if ($form->isValid($this->_request->getPost())) :
                $data = $this->_request->getPost();

                $Auth = new Auth_Model();
                $Auth->usuario = $data['usuario'];
                $Auth->senha = $data['senha'];
                $Auth->helper = $this->_helper;

                if ($Auth->login()) :
                    $this->_helper->FlashMessenger(array('sucess' => 'Bem vindo de volta!'));
                    $this->_redirect('/' . $this->module);
                else :
                    $this->_helper->FlashMessenger(array('error' => 'Dados Incorretos!'));
                endif;
            else :
                $this->_helper->FlashMessenger(array('error' => 'Preencha todos os campos obrigatórios!'));
                $form->populate($this->_request->getPost())->markAsError();
            endif;
        endif;

        $this->view->form = $form;
    }

    public function logoutAction() {
        $auth = new AuthErp_Model();
        $auth->logout();
        $this->_redirect('/' . $this->module);
    }

}

