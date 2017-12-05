<?php

class WS_Form_Element_Mail extends Zend_Form_Element_Text {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttribs(array(
                    'class' => array(
                        'filtro',
                        'email',
                        'ui-corner-all'
                    )
                ))
                ->addValidators(array(
                    'EmailAddress'
                ));
    }

}