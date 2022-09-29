<?php

class WS_Form_Element_Text extends Zend_Form_Element_Text {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttribs(
                        array(
                            'class' => array(
                                'ui-corner-all',
                                'border'
                            )
                        )
                )
                ->addFilter(new Zend_Filter_StripTags())
                ->addFilter(new Zend_Filter_StringTrim());
    }

}