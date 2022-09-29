<?php

class AdministradoresCondominios_Model extends WS_Model {

    public function __construct() {
        $this->_db = new AdministradoresCondominios_Db();
        $this->_pair = 'nome';
        $this->_title = 'Gerenciador de Administradores de Condomínios';
        $this->_singular = 'Administrador de Condomínio';
        $this->_plural = 'Administradores de Condomínios';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'ac.id';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from('administradores_condominios', array('id', 'nome'))
                ->order('nome');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ac' => 'administradores_condominios'), array('*'))
                ->joinLeft(array('c' => 'clientes'), 'ac.id = c.administrador_id', array('clientes' => 'COUNT(c.id)'))
                ->group('ac.id');
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'ac.nome' => 'text',
            'ac.telefone' => 'text',
            'ac.contato' => 'text',
        );
    }

    public function adjustToView(array $data) {
        $data['telefones'] = '<a href="tel:+55' . WS_Text::onlyNumber($data['telefone']) . '">' . str_replace('.', '-', $data['telefone']) . '</a>';
        if (!empty($data['telefone2'])):
            $data['telefones'] .= ' | <a href="tel:+55' . WS_Text::onlyNumber($data['telefone2']) . '">' . str_replace('.', '-', $data['telefone2']) . '</a>';
        endif;
        if (!empty($data['telefone3'])):
            $data['telefones'] .= ' | <a href="tel:+55' . WS_Text::onlyNumber($data['telefone3']) . '">' . str_replace('.', '-', $data['telefone3']) . '</a>';
        endif;
        return $data;
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'nome' => array(
                'label' => 'Nome',
                'type' => 'Text',
                'required' => true
            ),
            'contato' => array(
                'label' => 'Contato',
                'type' => 'Text'
            ),
            'email' => array(
                'label' => 'E-mail',
                'type' => 'Mail',
                'required' => true
            ),
            'telefone' => array(
                'label' => 'Telefone',
                'type' => 'Phone'
            ),
            'telefone_2' => array(
                'label' => 'Telefone 2',
                'type' => 'Phone'
            ),
            'telefone_3' => array(
                'label' => 'Telefone 3',
                'type' => 'Phone'
            ),
            'endereco' => array(
                'label' => 'Endereço',
                'type' => 'Text'
            )
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'telefones' => 'Telefones',
            'contato' => 'Contato',
            'clientes' => 'Clientes',
        );
    }

}