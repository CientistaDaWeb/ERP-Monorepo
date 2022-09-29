<?php

class Caminhoes_Model extends WS_Model
{

  public function __construct()
  {
    $this->_db = new Caminhoes_Db();
    $this->_pair = 'nome';
    $this->_title = 'Gerenciador de Caminhões';
    $this->_singular = 'Caminhão';
    $this->_plural = 'Caminhões';
    $this->_primary = 'c.id';
    $this->_layoutList = 'basic';

    parent::__construct();
  }

  public static function fetchPair()
  {
    $db = WS_Model::getDefaultAdapter();
    $sql = $db->select()
      ->from('caminhoes', array('id', 'nome'))
      ->order('nome');
    return $db->fetchPairs($sql);
  }

  public function setBasicSearch()
  {
    $this->_basicSearch = $this->_db->select()
      ->setIntegrityCheck(false)
      ->from(array('c' => 'caminhoes'), array('*'));
  }

  public function setSearchFields()
  {
    $this->_searchFields = array(
      'c.nome' => 'text',
      'c.placa' => 'text',
    );
  }

  public function setFormFields()
  {
    $this->_formFields = array(
      'id' => array(
        'type' => 'Hidden'
      ),
      'nome' => array(
        'label' => 'Nome do Caminhão',
        'type' => 'Text',
        'required' => true
      ),
      'placa' => array(
        'label' => 'Placa',
        'type' => 'Text',
        'required' => true
      ),
    );
  }

  public function setViewFields()
  {
    $this->_viewFields = array(
      'nome' => 'Nome',
      'placa' => 'Placa',
    );
  }

}
