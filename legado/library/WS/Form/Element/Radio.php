<?php

class WS_Form_Element_Radio extends Zend_Form_Element_Radio {

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