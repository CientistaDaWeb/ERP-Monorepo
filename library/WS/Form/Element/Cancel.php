<?php

class WS_Form_Element_Cancel extends WS_Form_Element_Button {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttribs(
                array(
                    'type' => 'button',
                    'class' => array(
                        'btCancelar'
                    )
                )
        );
    }

}