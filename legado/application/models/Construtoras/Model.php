<?php

class Construtoras_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Construtoras_Db();
        $this->_pair = 'nome';
        $this->_title = 'Gerenciador de Construtoras';
        $this->_singular = 'Construtora';
        $this->_plural = 'Construtoras';
        $this->_layoutList = 'basic';
        $this->_primary = 'c.id';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('c' => 'construtoras'), array('id', 'nome'))
                ->order('nome');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'construtoras'), array('*'))
                ->joinLeft(array('p' => 'projetos'), 'c.id = p.construtora_id', array('projetos' => 'COUNT(p.id)'))
                ->group('c.id');
        $this->_basicSearch->__toString();
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

    public function setSearchFields() {
        $this->_searchFields = array(
            'c.nome' => 'text',
            'c.telefone' => 'text',
            'c.contato' => 'text',
        );
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
            'telefone' => array(
                'label' => 'Telefone',
                'type' => 'Phone',
            ),
            'telefone_2' => array(
                'label' => 'Telefone 2',
                'type' => 'Phone'
            ),
            'telefone_3' => array(
                'label' => 'Telefone 3',
                'type' => 'Phone'
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'contato' => 'Contato',
            'projetos' => 'Projetos',
            'telefones' => 'Telefones'
        );
    }

}