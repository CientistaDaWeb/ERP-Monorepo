<?php

class Erp_ProjetosArquitetonicosArquivosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ProjetosArquitetonicosArquivos_Model();
        if ($this->_hasParam('parent_id')):
            $arquitetonico_id = $this->_getParam('parent_id');
            $this->model->_formFields['arquitetonico_id']['value'] = $arquitetonico_id;
        endif;
        $this->form = WS_Form_Generator::generateForm('ProjetosArquitetonicosArquivos', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        $arquitetonico_id = $this->_getParam('parent_id');
        if (!empty($arquitetonico_id)):
            $this->model->_params['arquitetonico_id'] = $arquitetonico_id;
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