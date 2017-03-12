<?php

class WS_Form_Element_Submit extends WS_Form_Element_Button {

    public function __construct($spec) {
        $this->setAttrib('type', 'submit')
                ->setAttribs(array(
                    'class' => array(
                        'btEnviar'
                    )
                ));
        parent::__construct($spec);
    }

}