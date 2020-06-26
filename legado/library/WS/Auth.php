<?php

class WS_Auth extends Zend_Auth {

    public function __construct($namespace = 'ws') {
        $this->setStorage(new Zend_Auth_Storage_Session($namespace));
    }

    static function getInstance() {
        throw new Zend_Auth_Exception('Sem suporte ao GetInstance');
    }

}
