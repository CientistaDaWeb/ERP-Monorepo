<?php

class WS_Form_Element_Ip extends WS_Form_Element_Text {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttribs(array(
                    'class' => array(
                        'filter',
                        'ip'
                    )
                ))
                ->addValidators(array(
                    'Ip'
                ))
                ;
    }

}