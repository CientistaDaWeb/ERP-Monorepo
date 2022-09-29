<?php

class AdministradoresArquivos_Model extends WS_Model {

    protected $_status;

    public function __construct() {
        $this->_db = new AdministradoresArquivos_Db();
        $this->_title = 'Gerenciador de Arquivos de Administradores';
        $this->_singular = 'Arquivo';
        $this->_plural = 'Arquivos';

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'administrador_id' => array(
                'type' => 'Hidden',
                'required' => true
            ),
            'descricao' => array(
                'type' => 'Text',
                'label' => 'Descrição',
                'required' => true
            ),
        );
    }

    public function adjustToDb(array $data) {
        unset($data['upload']);
        return parent::adjustToDb($data);
    }

    public function buscarPorAdministrador($administrador_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('aa' => 'administradores_arquivos'))
                ->joinInner(array('a' => 'administradores_condominios'), 'a.id = aa.administrador_id', array(''))
                ->where('aa.administrador_id = ?', $administrador_id)
        ;
        $itens = $sql->query()->fetchAll();
        return $itens;
    }

}
