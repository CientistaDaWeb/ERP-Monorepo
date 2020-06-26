<?php

class Erp_EmpresasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Empresas_Model();
        unset($this->buttons['del']);
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        $this->form = new Empresas_Form();
        if ($this->_request->isPost()):
            if ($this->form->isValid($this->_request->getPost())) :
                if ($_FILES['logo']['size'] > 0) {
                    $upload = new Upload($_FILES['logo']);
                    if ($upload->uploaded) {
                        $upload->image_resize = true;
                        $upload->image_ratio_fill = true;
                        $upload->image_x = 250;
                        $upload->image_y = 120;

                        $upload->Process(UPLOAD_PATH . '/logos');

                        if ($upload->processed) {
                            $this->model->_params['logomarca'] = $upload->file_dst_name;
                        } else {
                            $this->_helper->FlashMessenger(array('error' => $upload->error));
                        }
                    } else {
                        $this->_helper->FlashMessenger(array('error' => $upload->error));
                    }
                }
            endif;
        endif;
        parent::formularioAction();
    }

}