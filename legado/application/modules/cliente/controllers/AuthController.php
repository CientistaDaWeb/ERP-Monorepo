<?php

class Cliente_AuthController extends Cliente_Controller_Action {

    public function indexAction() {
        $form = new AuthCliente_Form();

        if ($this->_request->isPost()) :
            if ($form->isValid($this->_request->getPost())) :
                $data = $this->_request->getPost();

                $Auth = new AuthCliente_Model();
                $Auth->usuario = $data['usuario'];
                $Auth->senha = $data['senha'];
                $Auth->helper = $this->_helper;

                if ($Auth->login()) :
                    $this->_helper->FlashMessenger(array('sucess' => 'Bem vindo de volta!'));
                    $this->_redirect('/cliente');
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
        $auth = new AuthCliente_Model();
        $auth->logout();
        $this->_redirect('/cliente');
    }

}

