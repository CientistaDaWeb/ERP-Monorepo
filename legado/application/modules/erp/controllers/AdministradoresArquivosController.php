<?php

class Erp_AdministradoresArquivosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new AdministradoresArquivos_Model();
        $this->form = WS_Form_Generator::generateForm('AdministradoresArquivos', $this->model->getFormFields());
        parent::init();
    }

    public function administradorAction() {
        $administrador_id = $this->_getParam('parent_id');
        $this->view->paren_id = $administrador_id;
        $items = $this->model->buscarPorAdministrador($administrador_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $administrador_id = $this->_getParam('parent_id');
        if (!empty($administrador_id)):
            $this->model->_params['administrador_id'] = $administrador_id;
        endif;
        parent::formularioAction();
    }

    public function uploadAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $auth = new WS_Auth('erp');
        $dados = array();
        $dados['administrador_id'] = $this->_getParam('administrador_id');
        $dados['created'] = date('Y-m-d H:i:s');
        if ($this->_request->isPost()):
            if (!empty($_FILES)) {
                foreach ($_FILES AS $ARQUIVO) :
                    $upload = new Upload($ARQUIVO);
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/administradores-arquivos/');
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
