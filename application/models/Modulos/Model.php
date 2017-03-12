<?php

class Modulos_Model extends WS_Model {

    protected $_route;

    public function __construct() {
        $this->_db = new Modulos_Db();
        $this->_title = 'Gerenciador de Módulos';
        $this->_singular = 'Módulo';
        $this->_plural = 'Módulos';
        $this->_layoutList = 'basic';
        $this->_layoutForm = 'basic';
        $this->_primary = 'm.id';

        $this->_route = array(
            'M' => 'Módulo',
            'S' => 'Submodulo',
            'P' => 'Print'
        );
        parent::__construct();
    }

    public function findByCategory($categoria) {
        $query = $this->_db->select()
                ->where('categoria_id = ?', $categoria);
        return $query->query()->fetchAll();
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'titulo' => 'ASC'
        );
        return parent::setOrderFields();
    }

    public function findByController($controller) {
        $query = $this->_db->select()
                ->where('controller = ?', $controller);
        return $query->query()->fetch();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'modulos'), array('*'))
                ->joinInner(array('mc' => 'modulos_categorias'), 'mc.id = m.categoria_id', array('categoria'));
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'm.titulo' => 'text',
            'm.controller' => 'text',
            'mc.categoria' => 'text'
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'route' => 'getOption'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'titulo' => 'Título',
            'categoria' => 'Categoria',
            'controller' => 'Controlador',
            'ordem' => 'Ordem',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'categoria_id' => array(
                'label' => 'Categoria',
                'type' => 'Select',
                'option' => array('' => 'Selecione a categoria'),
                'options' => ModulosCategorias_Model::fetchPair(),
                'required' => true
            ),
            'titulo' => array(
                'label' => 'Título',
                'type' => 'Text',
                'required' => true
            ),
            'controller' => array(
                'label' => 'Controlador',
                'type' => 'Text',
                'required' => true
            ),
            'action' => array(
                'label' => 'Ação',
                'type' => 'Text',
                'required' => true
            ),
            'ordem' => array(
                'label' => 'Ordem',
                'type' => 'Number'
            ),
            'route' => array(
                'label' => 'Rota',
                'type' => 'Select',
                'options' => $this->_route,
                'required' => true
            )
        );
    }

    public function getPermissions($categoria_id, $usuario_id) {
        $sql = clone $this->_basicSearch;
        $sql->joinInner(array('um' => 'usuarios_modulos'), 'm.id = um.modulo_id', array(''))
                ->where('mc.id = ?', $categoria_id)
                ->where('um.usuario_id = ?', $usuario_id);
        return $sql->query()->fetchAll();
    }

}