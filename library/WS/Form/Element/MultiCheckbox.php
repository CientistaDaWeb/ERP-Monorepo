<?php

class WS_Form_Element_MultiCheckbox extends Zend_Form_Element_MultiCheckbox {

    public function __construct($spec) {
        $this->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'class' => array(
                        'ui-corner-all',
                        'border',
                        'checkbox',
                        'multicheck'
                    )
                ))
        ;
        parent::__construct($spec);
    }

}