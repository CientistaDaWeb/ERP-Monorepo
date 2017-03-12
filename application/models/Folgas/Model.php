<?php

class Folgas_Model extends WS_Model {

    protected $_status;

    public function __construct() {
        $this->_db = new Folgas_Db();
        $this->_title = 'Gerenciador de Folgas';
        $this->_singular = 'Folga';
        $this->_plural = 'Folgas';
        $this->_layoutList = 'basic';
        $this->_primary = 'f.id';

        parent::__construct();
        $this->turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('f' => 'folgas'), array('*'));
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date',
            'hora_inicio' => 'hour',
            'hora_fim' => 'hour',
        );
    }

    public function setOrderFields(){
        $this->_orderFields = array(
            'data' => 'DESC',
            'hora_inicio' => 'ASC'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'titulo' => 'Título',
            'data' => 'Data',
            'hora_inicio' => 'Início',
            'hora_fim' => 'Fim',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
             'id' => array(
                'type' => 'Hidden'
            ),
            'titulo' => array(
                'type' => 'Text',
                'label' => 'Titulo',
                'required' => true
            ),
            'data' => array(
                'type' => 'Date',
                'label' => 'Data',
                'required' => true
            ),
            'hora_inicio' => array(
                'type' => 'Hour',
                'label' => 'Hora de Início',
                'required' => true
            ),
            'hora_fim' => array(
                'type' => 'Hour',
                'label' => 'Hora de Fim',
                'required' => true
            ),
        );
    }
    public function agenda($inicio, $fim) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('f' => 'folgas'), array('*'))
                ->where('f.data >= ?', $inicio)
                ->where('f.data <= ?', $fim);

        return $consulta->query()->fetchAll();
    }

}
