<?php

class Erp_ClientesEnderecosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ClientesEnderecos_Model();
        $this->form = WS_Form_Generator::generateForm('ClientesEnderecos', $this->model->getFormFields());
        parent::init();
    }

    public function clienteAction() {
        $cliente_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $cliente_id = $this->_getParam('parent_id');
        if (!empty($cliente_id)):
            $this->model->_params['cliente_id'] = $cliente_id;
        endif;
        if ($this->_request->isPost()):
            if (!empty($_FILES)) {
                foreach ($_FILES AS $ARQUIVO) :
                    $upload = new Upload($ARQUIVO);
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/clientes-enderecos/');
                        if ($upload->processed) {
                            $this->model->_params['imagem'] = $upload->file_dst_name;
                        } else {
                            $this->_helper->FlashMessenger(array('error' => $upload->error));
                        }
                    } else {
                        $this->_helper->FlashMessenger(array('error' => $upload->error));
                    }
                endforeach;
            } else {
                echo 'Nenhum arquivo selecionado!';
            }
        endif;
        parent::formularioAction();
    }

    public function jsonAction() {
        $cliente_id = $this->_getParam('parent_id');
        if (!empty($cliente_id)):
            $this->model->_params['cliente_id'] = $cliente_id;
            $items = $this->model->buscarPorCliente($cliente_id);
            echo Zend_Json::encode($items);
        endif;
        exit();
    }

}
