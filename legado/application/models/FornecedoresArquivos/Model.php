<?php

class FornecedoresArquivos_Model extends WS_Model {

    protected $_status;

    public function __construct() {
        $this->_db = new FornecedoresArquivos_Db();
        $this->_title = 'Gerenciador de Arquivos de Fornecedores';
        $this->_singular = 'Arquivo';
        $this->_plural = 'Arquivos';

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'fornecedor_id' => array(
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

    public function buscarPorFornecedor($fornecedor_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('fa' => 'fornecedores_arquivos'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = fa.fornecedor_id', array(''))
                ->where('fa.fornecedor_id = ?', $fornecedor_id)
        ;
        $itens = $sql->query()->fetchAll();
        return $itens;
    }

}
