<?php

class WS_Form_Element_Checkbox extends Zend_Form_Element_Checkbox {

    public function __construct($spec) {
        $this->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'class' => array(
                        'ui-corner-all',
                        'border',
                        'checkbox'
                    )
                ))
                ->setDecorators(array(
                    array('ViewHelper'),
                    array('Label',
                        array(
                            'placement' => 'APPEND'
                        )
                    )
                ))
        ;
        parent::__construct($spec);
    }

}