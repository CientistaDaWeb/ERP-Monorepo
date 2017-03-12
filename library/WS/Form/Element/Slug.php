<?php

class WS_Form_Element_Slug extends Zend_Form_Element_Hidden {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->removeDecorator('label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'class' => array(
                        'filter',
                        'slug'
                    )
                ));
    }

}