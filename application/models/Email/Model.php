<?php

class Email_Model extends Zend_Mail {

    private $configs;
    private $config;
    public $layout;
    public $errorMessage;

    function __construct() {
        $this->configs = Zend_Registry::get('application');
        $this->config = array(
            'auth' => $this->configs->email->auth,
            'ssl' => $this->configs->email->ssl,
            'username' => $this->configs->email->username,
            'password' => $this->configs->email->password,
            'port' => $this->configs->email->port
        );
    }

    public function envia($remetenteEmail, $remetenteNome) {
        $transport = new Zend_Mail_Transport_Smtp($this->configs->email->host, $this->config);
        $this->addHeader('Disposition-Notification-To', 'acquasana@acquasana.com.br');
        $this->setFrom($remetenteEmail, $remetenteNome);
        $this->send($transport);
    }

}