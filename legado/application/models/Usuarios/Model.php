<?php

class Usuarios_Model extends WS_Model {

    protected $_papel, $_ponto;

    public function __construct() {
        $this->_db = new Usuarios_Db();
        $this->_pair = 'nome';
        $this->_title = 'Gerenciador de Usuários';
        $this->_singular = 'Usuário';
        $this->_plural = 'Usuários';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_papel = array(
            'U' => 'Não',
            'A' => 'Sim'
        );
        $this->_ponto = array(
            'N' => 'Não',
            'S' => 'Sim'
        );
        $this->_ativo = array(
            'N' => 'Não',
            'S' => 'Sim'
        );

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('u' => 'usuarios'), array('id', 'nome'))
                ->where('u.ativo = ?', 'S')
                ->order('nome');
        return $db->fetchPairs($sql);
    }

    public static function fetchPairPonto() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from('usuarios', array('id', 'nome'))
                ->where('ponto = "S"')
                ->order('nome');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('u' => 'usuarios'), array('*'));
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'usuario' => 'text',
            'nome' => 'text',
            'papel' => 'getKey',
            'ativo' => 'getKey',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'papel' => 'getOption',
            'ativo' => 'getOption',
            'usuario' => 'slug',
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'ativo' => 'asc',
            'nome' => 'asc',
            'usuario' => 'asc'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'usuario' => 'Usuario',
            'papel' => 'Administrador',
            'ativo' => 'Ativo',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'ativo' => array(
                'type' => 'Select',
                'label' => 'Ativo no sistema?',
                'option' => array('' => 'Selecione'),
                'options' => $this->_ativo,
            ),
            'nome' => array(
                'type' => 'Text',
                'label' => 'Nome',
                'required' => true
            ),
            'usuario' => array(
                'type' => 'Text',
                'label' => 'Usuário',
                'required' => true
            ),
            'senha' => array(
                'type' => 'Password',
                'label' => 'Senha'
            ),
            'cargo' => array(
                'type' => 'Text',
                'label' => 'Cargo'
            ),
            'pis' => array(
                'type' => 'Text',
                'label' => 'PIS'
            ),
            'telefone' => array(
                'type' => 'Phone',
                'label' => 'Telefone',
                'required' => true,
            ),
            'email' => array(
                'type' => 'Mail',
                'label' => 'E-mail',
                'required' => true
            ),
            'ponto' => array(
                'type' => 'Select',
                'label' => 'Usa o Ponto?',
                'option' => array('' => 'Selecione'),
                'options' => $this->_ponto
            ),
            'token_ponto' => array(
                'type' => 'Text',
                'label' => 'Token',
                'required' => true
            ),
            'papel' => array(
                'type' => 'Select',
                'label' => 'Administrador',
                'option' => array('' => 'Selecione'),
                'options' => $this->_papel
            )
        );
    }

    public function adjustToDb(array $data) {
        if ($data['senha']):
            $data['senha'] = sha1($data['senha']);
        else:
            unset($data['senha']);
        endif;
        return parent::adjustToDb($data);
    }

    public function findByToken($token) {
        $sql = $this->_db->select()
                ->from(array('u' => 'usuarios'), array('id', 'nome'))
                ->where('u.token_ponto = ?', $token);

        return $sql->query()->fetch();
    }

    public function faltantes() {
        $PontoModel = new Pontos_Model();
        $ultima = $PontoModel->ultima();
        $faltantes = $PontoModel->faltantes($ultima['data']);
        return $faltantes;
    }

    public function buscaFaltantes($usuarios) {
        $sql = $this->_db->select()
                ->from(array('u' => 'usuarios'), array('id', 'nome'))
                ->where('u.id NOT IN(?)', $usuarios)
                ->where('u.ponto = ?', 'S');
        return $sql->query()->fetchAll();
    }

    public function buscaPonto() {
        $sql = $this->_db->select()
                ->from(array('u' => 'usuarios'), array('id', 'nome'))
                ->where('u.ponto = ?', 'S')
                ->where('u.ativo = ?', 'S')
        ;
        return $sql->query()->fetchAll();
    }

    public function findByPis($pis) {
        $sql = $this->_db->select()
                ->from(array('u' => 'usuarios'), array('id', 'nome'))
                ->where('u.pis = ?', $pis);

        return $sql->query()->fetch();
    }

}
