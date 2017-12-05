<?php

class WS_Form_Element_Url extends WS_Form_Element_Text {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttribs(array(
                    'class' => array(
                        'filter',
                        'url'
                    )
                ))
                ->addValidator(new WS_Validate_Url());
    }

}