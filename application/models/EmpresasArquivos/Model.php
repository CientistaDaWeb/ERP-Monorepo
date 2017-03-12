<?php

class EmpresasArquivos_Model extends WS_Model {

    protected $_status;

    public function __construct() {
        $this->_db = new EmpresasArquivos_Db();
        $this->_title = 'Gerenciador de Arquivos de Empresas';
        $this->_singular = 'Arquivo';
        $this->_plural = 'Arquivos';

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'empresa_id' => array(
                'type' => 'Hidden',
                'required' => true
            ),
            'categoria_id' => array(
                'type' => 'Select',
                'label' => 'Categoria',
                'option' => array('' => 'Selecione a categoria ...'),
                'options' => EmpresasArquivosCategorias_Model::fetchPair(),
                'required' => true,
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

    public function buscarPorEmpresa($empresa_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ea' => 'empresas_arquivos'))
                ->joinInner(array('eac' => 'empresas_arquivos_categorias'), 'eac.id = ea.categoria_id', array('categoria'))
                ->joinInner(array('e' => 'empresas'), 'e.id = ea.empresa_id', array(''))
                ->where('ea.empresa_id = ?', $empresa_id)
                ->order('eac.categoria')
                ->order('ea.descricao')
        ;
        $itens = $sql->query()->fetchAll();
        return $itens;
    }

    public function formContador() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'empresa_id' => array(
                'type' => 'Hidden',
                'required' => true
            ),
            'nome' => array(
                'type' => 'Text',
                'label' => 'Nome do Arquivo',
                'required' => true
            ),
            'descricao' => array(
                'type' => 'Text',
                'label' => 'Descrição',
                'required' => true
            ),
            'pis' => array(
                'type' => 'File',
                'label' => 'PIS',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'gps' => array(
                'type' => 'File',
                'label' => 'GPS',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'cofins' => array(
                'type' => 'File',
                'label' => 'COFINS',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'imposto_renda' => array(
                'type' => 'File',
                'label' => 'Imposto de Renda',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'csoc' => array(
                'type' => 'File',
                'label' => 'CSOC',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'fundo_garantia' => array(
                'type' => 'File',
                'label' => 'Fundo de Garantia',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'espelho_ponto' => array(
                'type' => 'File',
                'label' => 'Espelho do Ponto',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'simples_nacional' => array(
                'type' => 'File',
                'label' => 'Simples Nacional',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'iss' => array(
                'type' => 'File',
                'label' => 'ISS',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'sindicato_trabalhadores' => array(
                'type' => 'File',
                'label' => 'Sindicato dos Trabalhadores de Transporte',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'extrato_acquasana' => array(
                'type' => 'File',
                'label' => 'Extrato bancário Acquasana',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'extrato_fundacorp' => array(
                'type' => 'File',
                'label' => 'Extrato bancário Fundacorp',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'contas_receber' => array(
                'type' => 'File',
                'label' => 'Relatório de contas a receber',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'contas_receber_acqualife' => array(
                'type' => 'File',
                'label' => 'Relatório de contas a receber Acqualife',
                'ignore' => true,
                'extension' => array('pdf'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'cte' => array(
                'type' => 'File',
                'label' => 'Lote de Cte-s',
                'ignore' => true,
                'extension' => array('rar','zip'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
            'cte_acqualife' => array(
                'type' => 'File',
                'label' => 'Lote de Cte-s Acqualife',
                'ignore' => true,
                'extension' => array('rar','zip'),
                'size' => array('max' => '60728640', 'min' => '0'),
            ),
        );
        return $this->_formFields;
    }

}
