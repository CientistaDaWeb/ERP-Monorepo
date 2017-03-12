<?php

class WS_Form_Element_Textarea extends Zend_Form_Element_Textarea {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttribs(array(
            'class' => array(
                'ui-corner-all',
                'border'
            ),
            'rows' => '5'
        ));
    }

}