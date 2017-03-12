<?php

class Storage_ImageController extends Zend_Controller_Action {

    public function resizeAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $data = $this->_getAllParams();

        $image = new Storage_Imagem_Model();
        $imagem = $image->buscaImagem($data);
    }

}