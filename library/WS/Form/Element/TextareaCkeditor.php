<?php

class WS_Form_Element_TextareaCkeditor extends Zend_Form_Element_Textarea {

    public function __construct($spec) {
        parent::__construct($spec);
        $this->setAttribs(array(
            'class' => array(
                'ckeditor',
            ),
            'rows' => '5'
        ));
    }

}