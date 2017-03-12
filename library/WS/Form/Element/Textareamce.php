<?php

class WS_Form_Element_Textareamce extends Zend_Form_Element_Textarea {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttribs(array(
            'class' => array(
                'ui-corner-all',
                'border',
                'mce'
            ),
            'rows' => '5'
        ));
    }

}