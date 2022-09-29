<?php

class Storage_FileController extends Zend_Controller_Action {

    public function getAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $data = $this->_getAllParams();

        $file = new Storage_File_Model();
        $file->buscaFile($data);
    }

}