<?php

class WS_Validate_Url extends Zend_Validate_Abstract {
    const MSG_URI = 'msgUri';

    protected $_messageTemplates = array(
        self::MSG_URI => "Url Inválida",
    );

    public function isValid($value) {
        $this->_setValue($value);

        $valid = Zend_Uri::check($value);

        if ($valid) {
            return true;
        } else {
            $this->_error(self::MSG_URI);
            return false;
        }
    }

}