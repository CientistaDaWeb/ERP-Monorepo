<?php

class Erp_OrdemServicoImagensController extends Erp_Controller_Action {

    public function init() {
        $this->model = new OrdemServicoImagens_Model();
        if ($this->_hasParam('parent_id')):
            $ordem_servico_id = $this->_getParam('parent_id');
            $this->model->_formFields['ordem_servico_id']['value'] = $ordem_servico_id;
        endif;
        $this->form = WS_Form_Generator::generateForm('OrdemServicoImagens', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        $ordem_servico_id = $this->_getParam('parent_id');
        if (!empty($ordem_servico_id)):
            $this->model->_params['ordem_servico_id'] = $ordem_servico_id;
        endif;

        parent::formularioAction();
    }

    public function uploadAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $auth = new WS_Auth('erp');
        $dados = array();
        $dados['ordem_servico_id'] = $this->_getParam('ordem_servico_id');
        $dados['local'] = $this->_getParam('local');
        $dados['created'] = date('Y-m-d H:i:s');
        if ($this->_request->isPost()):
            if (!empty($_FILES)) {
                foreach ($_FILES AS $ARQUIVO) :
                    $upload = new Upload($ARQUIVO);
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/ordem-servico/');
                        if ($upload->processed) {
                            $dados['arquivo'] = $upload->file_dst_name;
                            $dados['legenda'] = $upload->file_dst_name;
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
                echo 'Nenhuma imagem selecionada!';
            }
            if (isset($sucesso)):
                echo '1';
            endif;
        else:
            echo 'Formul&aacute;rio n&atilde;o enviado corretamente!';
        endif;
        exit();
    }

    public function ordemservicoAction() {
        $ordem_servico_id = $this->_getParam('parent_id');
        $this->view->data['parent_id'] = $ordem_servico_id;
        if (!empty($ordem_servico_id)):
            $items = $this->model->getByOS($ordem_servico_id);
            $this->view->items = $items;
        endif;
    }

}
