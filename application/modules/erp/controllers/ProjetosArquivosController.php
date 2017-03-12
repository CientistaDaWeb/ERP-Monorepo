<?php

class Erp_ProjetosArquivosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ProjetosArquivos_Model();
        $this->form = WS_Form_Generator::generateForm('ProjetosArquivos', $this->model->getFormFields());
        parent::init();
    }

    public function projetoAction() {
        $projeto_id = $this->_getParam('parent_id');
        $this->view->data['parent_id'] = $projeto_id;
        $items = $this->model->getByProject($projeto_id);
        $this->view->items = $items;

    }

    public function formularioAction() {
        /*
        $auth = new WS_Auth('erp');
        $usuario = $auth->getIdentity();

        if (!$this->_hasParam('usuario_id')):
            $this->model->_params['usuario_id'] = $usuario->id;
            $dados['usuario_id'] = $usuario->id;
        endif;
         */

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

    public function uploadAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $auth = new WS_Auth('erp');
        $dados = array();
        $dados['projeto_id'] = $this->_getParam('projeto_id');
        $dados['categoria_id'] = $this->_getParam('categoria_id');
        $dados['created'] = date('Y-m-d H:i:s');
        if ($this->_request->isPost()):
            if (!empty($_FILES)) {
                foreach ($_FILES AS $ARQUIVO) :
                    $upload = new Upload($ARQUIVO);
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/projetos/');
                        if ($upload->processed) {
                            $dados['arquivo'] = $upload->file_dst_name;
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