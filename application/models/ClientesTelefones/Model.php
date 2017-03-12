<?php

class ClientesTelefones_Model extends WS_Model {

    protected $_padrao;

    public function __construct() {
        $this->_db = new ClientesTelefones_Db();
        $this->_title = 'Gerenciador de Telefones de Clientes';
        $this->_singular = 'Contato';
        $this->_plural = 'Contatos';

        $this->_padrao = array(
            'N' => 'Não',
            'S' => 'Sim'
        );

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'cliente_id' => array(
                'type' => 'Hidden',
                'required' => true,
            ),
            'categoria_id' => array(
                'type' => 'Select',
                'label' => 'Categoria',
                'option' => array('' => 'Selecione a categoria'),
                'options' => TelefonesCategorias_Model::fetchPair(),
                'required' => true
            ),
            'contato' => array(
                'type' => 'Text',
                'label' => 'Contato',
            ),
            'telefone' => array(
                'type' => 'Phone',
                'label' => 'Telefone',
                'required' => true,
            ),
            'email' => array(
                'type' => 'Mail',
                'label' => 'E-mail',
            ),
            'informacao' => array(
                'type' => 'Text',
                'label' => 'Informação Adicional'
            ),
            'padrao' => array(
                'type' => 'Select',
                'label' => 'Padrão',
                'options' => $this->_padrao,
                'required' => true,
            ),
        );
    }

    public function adjustToView(array $data) {
        //$data['telefone'] = str_replace('.', '-', $data['telefone']);
        $data['telefone'] = '<a href="tel:+55' . WS_Text::onlyNumber($data['telefone']) . '">' . str_replace('.', '-', $data['telefone']) . '</a>';
        return parent::adjustToView($data);
    }

    public function buscaTelefones($cliente_id) {
        $consulta = $this->_db->select()
                ->from(array('ct' => 'clientes_telefones'), array('telefone'))
                ->where('ct.cliente_id = ?', $cliente_id);

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarPorCliente($cliente_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ct' => 'clientes_telefones'))
                ->joinInner(array('tc' => 'telefones_categorias'), 'tc.id = ct.categoria_id', array('categoria'))
                ->where('ct.cliente_id = ?', $cliente_id)
                ->order('padrao DESC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function zeraPadrao($cliente_id) {
        $data['padrao'] = 'N';
        $where = $this->_db->getAdapter()->quoteInto('cliente_id = ?', $cliente_id);
        $this->_db->update($data, $where);
    }

}
