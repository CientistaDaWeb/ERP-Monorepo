<?php

class Transportadores_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Transportadores_Db();
        $this->_pair = 'razao_social';
        $this->_title = 'Gerenciador de Transportadores';
        $this->_singular = 'Transportador';
        $this->_plural = 'Transportadores';
        $this->_primary = 't.id';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from('transportadores', array('id', 'razao_social'))
                ->order('razao_social');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('t' => 'transportadores'), array('*'))
                ->joinLeft(array('os' => 'ordens_servico'), 't.id = os.transportador_id', array('os' => 'COUNT(os.id)'))
                ->joinInner(array('m' => 'municipios'), 'm.id = t.municipio_id', array('municipio' => 'nome', 'codigo_municipio' => 'codigo'))
                ->joinInner(array('e' => 'estados'), 'e.id = m.estado_id', array('uf', 'codigo_uf' => 'codigo'))
                ->group('t.id');
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

    public function setViewFields() {
        $this->_viewFields = array(
            'razao_social' => 'Empresa',
            'os' => 'Nº OS',
            'telefones' => 'Telefones',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'documento' => array(
                'label' => 'CNPJ',
                'type' => 'Cnpj',
                'required' => true
            ),
            'inscricao_estadual' => array(
                'label' => 'Inscrição Estadual',
                'type' => 'Text'
            ),
            'inscricao_municipal' => array(
                'label' => 'Inscrição Municipal',
                'type' => 'Text'
            ),
            'razao_social' => array(
                'label' => 'Razão Social',
                'type' => 'Text',
                'required' => true
            ),
            'nome_fantasia' => array(
                'label' => 'Nome Fantasia',
                'type' => 'Text'
            ),
            'email' => array(
                'label' => 'E-mail',
                'type' => 'Mail',
                'required' => true
            ),
            'estado_id' => array(
                'label' => 'Estado',
                'type' => 'Select',
                'option' => array('' => 'Selecione o Estado...'),
                'options' => Estados_Model::fetchPair(),
                'required' => true
            ),
            'municipio_id' => array(
                'type' => 'Select',
                'label' => 'Cidade',
                'option' => array('' => 'Escolha a cidade...'),
                'options' => Municipios_Model::fetchPair(),
                'required' => true
            ),
            'cep' => array(
                'label' => 'Cep',
                'type' => 'Cep',
                'required' => true
            ),
            'endereco' => array(
                'label' => 'Endereço',
                'type' => 'Text',
                'required' => true
            ),
            'bairro' => array(
                'label' => 'Bairro',
                'type' => 'Text',
                'required' => true
            ),
            'numero' => array(
                'label' => 'Nº',
                'type' => 'Number',
                'required' => true
            ),
            'complemento' => array(
                'label' => 'Complemento',
                'type' => 'Text'
            ),
            'telefone' => array(
                'label' => 'Telefone',
                'type' => 'Phone',
                'required' => true
            ),
            'telefone2' => array(
                'label' => 'Telefone 2',
                'type' => 'Phone'
            ),
            'telefone3' => array(
                'label' => 'Telefone 3',
                'type' => 'Phone'
            ),
            'lo' => array(
                'label' => 'Nº LO',
                'type' => 'Text',
                'required' => true
            ),
        );
    }

}
