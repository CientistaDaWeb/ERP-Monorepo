<?php

class Erp_ClientesArquivosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ClientesArquivos_Model();
        $this->form = WS_Form_Generator::generateForm('ClientesArquivos', $this->model->getFormFields());
        parent::init();
    }

    public function clienteAction() {
        $cliente_id = $this->_getParam('parent_id');
        $this->view->paren_id = $cliente_id;
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $cliente_id = $this->_getParam('parent_id');
        if (!empty($cliente_id)):
            $this->model->_params['cliente_id'] = $cliente_id;
        endif;
        parent::formularioAction();
    }

    public function uploadAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $auth = new WS_Auth('erp');
        $dados = array();
        $dados['cliente_id'] = $this->_getParam('cliente_id');
        $dados['created'] = date('Y-m-d H:i:s');
        if ($this->_request->isPost()):
            if (!empty($_FILES)) {
                foreach ($_FILES AS $ARQUIVO) :
                    $upload = new Upload($ARQUIVO);
                    $upload->mime_check = false;
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/clientes-arquivos/');
                        if ($upload->processed) {
                            $dados['arquivo'] = $upload->file_dst_name;
                            $dados['descricao'] = $upload->file_dst_name;
                            $dados['created'] = date('Y-m-d H:i:s');
                            $this->model->_db->insert($dados, $this->model->getOption('messages', 'add'), $this->model->_db->getTableName());
                            $sucesso = true;
                        } else {
                            echo $upload->error;
                        }
                    } else {
                        echo $upload->error;
                    }
                endforeach;
            } else {
                echo 'Nenhum arquivo selecionado!';
            }
            if (isset($sucesso)):
                echo '1';
            endif;
        else:
            echo 'Formul&aacute;rio n&atilde;o enviado corretamente!';
        endif;
        exit();
    }

}
