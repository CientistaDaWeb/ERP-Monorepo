<?php

class WS_Form_Element_Hidden extends Zend_Form_Element_Hidden {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setDecorators(array('ViewHelper'));
    }

}