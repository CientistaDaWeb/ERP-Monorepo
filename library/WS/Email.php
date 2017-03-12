<?php

class WS_Email extends Zend_Mail {

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

    public function Envia($remetenteEmail = NULL, $remetenteNome = NULL) {
        if(!$remetenteEmail):
            $remetenteEmail = $this->configs->cliente->email;
            $remetenteNome = $this->configs->cliente->nome;
        endif;

        $transport = new Zend_Mail_Transport_Smtp($this->configs->email->host, $this->config);
        //$this->setFrom($remetenteEmail, $remetenteNome);
        $this->send($transport);
    }

    /*

      public function __construct() {
      $configs = Zend_Registry::get('application');

      $data = array();
      $data['username'] = $configs->email->username;
      $data['password'] = $configs->email->password;

      if (!empty($configs->email->auth)):
      $data['auth'] = $configs->email->auth;
      endif;
      if (!empty($configs->email->ssl)):
      $data['ssl'] = $configs->email->ssl;
      endif;
      if (!empty($configs->email->port)):
      $data['port'] = $configs->email->port;
      endif;


      $this->transport = new Zend_Mail_Transport_Smtp($configs->email->host, $data);
      $this->setDefaultTransport($this->transport);
      $this->addTo($configs->cliente->email, $configs->cliente->nome);
      }

      public function Envia() {
      $configs = Zend_Registry::get('application');
      $this->send($this->transport);
      } */
}
