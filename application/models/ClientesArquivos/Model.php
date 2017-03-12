<?php

class ClientesArquivos_Model extends WS_Model {

    protected $_status;

    public function __construct() {
        $this->_db = new ClientesArquivos_Db();
        $this->_title = 'Gerenciador de Arquivos de Clientes';
        $this->_singular = 'Arquivo';
        $this->_plural = 'Arquivos';

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'cliente_id' => array(
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

    public function buscarPorCliente($cliente_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ca' => 'clientes_arquivos'))
                ->joinInner(array('c' => 'clientes'), 'c.id = ca.cliente_id', array(''))
                ->where('ca.cliente_id = ?', $cliente_id)
        ;
        $itens = $sql->query()->fetchAll();
        return $itens;
    }

}
