<?php

class Auth_Model extends Zend_Auth_Adapter_DbTable {

    public function login() {
        $this->setTableName('usuarios')
                ->setIdentityColumn('usuario')
                ->setIdentity($this->usuario)
                ->setCredentialColumn('senha')
                ->setCredential($this->senha)
                ->setCredentialTreatment('SHA1(?) AND ativo = "S"');

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

    public function getFormFields(){
        $this->setFormFields();
        return $this->_formFields;
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'usuario' => array(
                'label' => 'Usuário',
                'type' => 'Text',
                'required' => true
            ),
            'senha' => array(
                'label' => 'Senha',
                'type' => 'Password',
                'required' => true
            ),
        );
    }

    public function logout() {
        $auth = new WS_Auth('erp');
        $auth->clearIdentity();
    }

}