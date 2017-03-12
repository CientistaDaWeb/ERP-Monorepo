<?php

class AuthCliente_Model extends Zend_Auth_Adapter_DbTable {

    public function login() {
        $this->setTableName('clientes')
                ->setIdentityColumn('usuario')
                ->setIdentity($this->usuario)
                ->setCredentialColumn('senha')
                ->setCredential($this->senha);

        $logar = $this->authenticate();

        if ($logar->isValid()) {
            $auth = new WS_Auth('cliente');
            $data = $this->getResultRowObject(null, 'senha');
            $auth->getStorage()->write($data);
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        $auth = new WS_Auth('cliente');
        $auth->clearIdentity();
    }

}