<?php

class WS_Form_Element_CidMask extends Zend_Form_Element_Select {

    public function __construct($spec) {
        $model = new CidMask_Model();
        $this->setAttribs(array(
            'class' => array(
                'ui-corner-all'
            )
        ));
        $this->addMultiOptions($model->listMascaras());
        parent::__construct($spec);
    }

}