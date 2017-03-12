<?php

class WS_Form_Element_Button extends Zend_Form_Element_Button {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttrib('type', 'submit')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('label')
                ->setIgnore(true);
    }

}