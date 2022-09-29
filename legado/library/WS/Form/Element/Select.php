<?php

class WS_Form_Element_Select extends Zend_Form_Element_Select {

    public function __construct($spec) {
        $this->setAttribs(array(
            'class' => array(
                'ui-corner-all',
                'border',
            )
        ));
        parent::__construct($spec);
    }

}