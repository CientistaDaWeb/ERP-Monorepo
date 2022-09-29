<?php

class Erp_ProjetosArquitetonicosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ProjetosArquitetonicos_Model();
        if ($this->_hasParam('parent_id')):
            $projeto_id = $this->_getParam('parent_id');
            $this->model->_formFields['projeto_id']['value'] = $projeto_id;
        endif;
        $this->form = WS_Form_Generator::generateForm('ProjetosArquitetonicos', $this->model->getFormFields());
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
        endif;

        if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) :
            $upload = new Upload($_FILES['upload']);
            if ($upload->uploaded) :
                $upload->Process(UPLOAD_PATH . 'projetos-arquitetonicos');

                if ($upload->processed) :
                    $this->model->_params['arquivo'] = $upload->file_dst_name;
                else :
                    $this->_helper->FlashMessenger(array('error' => $upload->error));
                endif;
            else:
                $this->_helper->FlashMessenger(array('error' => $upload->error));
            endif;
        endif;

        parent::formularioAction();
    }

}