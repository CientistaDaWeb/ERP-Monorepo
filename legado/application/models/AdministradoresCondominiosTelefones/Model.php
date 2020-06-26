<?php

class AdministradoresCondominiosTelefones_Model extends WS_Model {

    protected $_padrao;

    public function __construct() {
        $this->_db = new AdministradoresCondominiosTelefones_Db();
        $this->_title = 'Gerenciador de Telefones de Administradores de Condomínios';
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
            'administrador_condominio_id' => array(
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

    public function buscaTelefones($administrador_id) {
        $consulta = $this->_db->select()
                ->from(array('act' => 'administradores_condominios_telefones'), array('telefone'))
                ->where('act.administrador_id = ?', $administrador_id);

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarPorAdministrador($administrador_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('act' => 'administradores_condominios_telefones'))
                ->joinInner(array('tc' => 'telefones_categorias'), 'tc.id = act.categoria_id', array('categoria'))
                ->where('act.administrador_condominio_id = ?', $administrador_id)
                ->order('padrao DESC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function zeraPadrao($administrador_id) {
        $data['padrao'] = 'N';
        $where = $this->_db->getAdapter()->quoteInto('administrador_condominio_id = ?', $administrador_id);
        $this->_db->update($data, $where);
    }

}
