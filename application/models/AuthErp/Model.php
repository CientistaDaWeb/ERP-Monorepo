<?php

class AuthErp_Model extends Zend_Auth_Adapter_DbTable {

    public function login() {
        $this->setTableName('usuarios')
                ->setIdentityColumn('usuario')
                ->setIdentity($this->usuario)
                ->setCredentialColumn('senha')
                ->setCredential($this->senha)
                ->setCredentialTreatment('SHA1(?)');

        $logar = $this->authenticate();
        if ($logar->isValid()) {
            $auth = new WS_Auth('erp');
            $data = $this->getResultRowObject(null, 'senha');
            $auth->getStorage()->write($data);

            $log = new WS_LogsAcessos_Model();

            $usuario = $auth->getIdentity();

            $data = null;

            $ultimoAcesso = $log->getLastAccess($usuario->id);
            if ($ultimoAcesso):
                $ZD = new Zend_Date($ultimoAcesso['created']);
                $this->helper->flashMessenger(array('sucess' => 'Seu último acesso foi ' . $ZD->toString('dd/MM/YYYY HH:mm:ss') . '!'));
            endif;

            $data['usuario_id'] = $usuario->id;
            $data['ip'] = $_SERVER['REMOTE_ADDR'];
            $data['navegador'] = $_SERVER['HTTP_USER_AGENT'];

            $log->log($data);

            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        $auth = new WS_Auth('erp');
        $auth->clearIdentity();
    }

}