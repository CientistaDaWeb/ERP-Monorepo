<?php

class Erp_MunicipiosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Municipios_Model();
        $this->form = WS_Form_Generator::generateForm('Municipios', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

    public function jsonAction() {
        $estado_id = $this->_getParam('parent_id');
        if (!empty($estado_id)):
            $items = $this->model->fetchPair($estado_id);
            foreach ($items AS $id => $item):
                $retorno[$item] = $id;
            endforeach;
            echo Zend_Json::encode($retorno);
        endif;
        exit();
    }

}