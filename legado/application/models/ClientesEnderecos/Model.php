<?php

class ClientesEnderecos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ClientesEnderecos_Db();
        $this->_title = 'Gerenciador de Endereços de Clientes';
        $this->_singular = 'Endereço';
        $this->_plural = 'Endereços';
        $this->_layoutForm = false;
        $this->_primary = 'ce.id';

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'imagem' => array(
                'type' => 'Hidden'
            ),
            'cliente_id' => array(
                'type' => 'Hidden',
                'required' => true
            ),
            'categoria_id' => array(
                'type' => 'Select',
                'label' => 'Categoria',
                'option' => array('' => 'Selecione a categoria'),
                'options' => EnderecosCategorias_Model::fetchPair(),
                'required' => true
            ),
            'estado_id' => array(
                'type' => 'Select',
                'label' => 'Estado',
                'option' => array('' => 'Selecione o estado'),
                'options' => Estados_Model::fetchPair(),
                'required' => true
            )
            , 'municipio_id' => array(
                'type' => 'Select',
                'label' => 'Cidade',
                'option' => array('' => 'Selecione o estado'),
                'options' => Municipios_Model::fetchPair(),
                'required' => true
            ),
            'cep' => array(
                'type' => 'Cep',
                'label' => 'Cep',
                'required' => true
            ),
            'endereco' => array(
                'type' => 'Text',
                'label' => 'Endereço',
                'required' => true
            ),
            'bairro' => array(
                'type' => 'Text',
                'label' => 'Bairro',
                'required' => true
            ),
            'numero' => array(
                'type' => 'Number',
                'label' => 'Número',
                'required' => true
            ),
            'complemento' => array(
                'type' => 'Text',
                'label' => 'Complemento',
            ),
            'coordenadas' => array(
                'type' => 'Text',
                'label' => 'Coordenadas GPS (long,lat)',
            ),
            'imagem' => array(
                'type' => 'File',
                'label' => 'Fachada',
                'extension' => array('png', 'jpg'),
                'ignore' => true,
            ),
        );
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ce' => 'clientes_enderecos'), '*')
                ->joinInner(array('m' => 'municipios'), 'm.id = ce.municipio_id', array('municipio' => 'nome'))
                ->joinInner(array('ec' => 'enderecos_categorias'), 'ec.id = ce.categoria_id', array('categoria'))
                ->joinInner(array('e' => 'estados'), 'e.id = ce.estado_id', array('uf'));
    }

    public function buscarPorCliente($cliente_id) {
        $consulta = clone($this->_basicSearch);
        $consulta->where('ce.cliente_id = ?', $cliente_id);
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscaPorId($id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ce' => 'clientes_enderecos'), array('*'))
                ->joinInner(array('m' => 'municipios'), 'm.id = ce.municipio_id', array('municipio' => 'nome', 'codigo_municipio' => 'codigo'))
                ->joinInner(array('ec' => 'enderecos_categorias'), 'ec.id = ce.categoria_id', array('categoria'))
                ->joinInner(array('e' => 'estados'), 'e.id = m.estado_id', array('uf', 'codigo_uf' => 'codigo'))
                ->joinInner(array('c' => 'clientes'), 'c.id = ce.cliente_id', array('razao_social'))
                ->where('ce.id = ?', $id);
        $itens = $consulta->query()->fetch();
        return $itens;
    }

    public function listagemMapa() {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ce' => 'clientes_enderecos'), array('*'))
                ->joinInner(array('ec' => 'enderecos_categorias'), 'ec.id = ce.categoria_id', array('categoria'))
                ->joinInner(array('c' => 'clientes'), 'c.id = ce.cliente_id', array('razao_social'))
                ->where('ce.coordenadas IS NOT NULL')
                ->where('ce.coordenadas != ""')
        ;
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function getSumByClient($cliente_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ce' => 'clientes_enderecos'), array('total' => 'COUNT(ce.id)'))
                ->joinInner(array('ec' => 'enderecos_categorias'), 'ec.id = ce.categoria_id', array(''))
                ->joinInner(array('e' => 'estados'), 'e.id = ce.estado_id', array(''))
                ->where('ce.cliente_id = ?', $cliente_id);
        return $sql->query()->fetch();
    }

    public static function fetchPair($cliente_id = '', $orcamento_id = '') {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('ce' => 'clientes_enderecos'), array('id', 'end' => 'CONCAT(ce.endereco," ", ce.numero," - ",m.nome)'))
                ->joinInner(array('m' => 'municipios'), 'm.id = ce.municipio_id', array(''))
                ->joinInner(array('ec' => 'enderecos_categorias'), 'ec.id = ce.categoria_id', array(''))
                ->joinInner(array('e' => 'estados'), 'e.id = ce.estado_id', array(''))
                ->joinInner(array('c' => 'clientes'), 'c.id = ce.cliente_id', array(''))
                ->group('ce.id')
                ->order('end');
        if (!empty($cliente_id)):
            $sql->where('c.id = ?', $cliente_id);
        endif;
        if (!empty($orcamento_id)):
            $sql->joinInner(array('o' => 'orcamentos'), 'c.id = o.cliente_id', array(''))
                    ->where('o.id = ?', $orcamento_id);
        endif;
        return $db->fetchPairs($sql);
    }

}
