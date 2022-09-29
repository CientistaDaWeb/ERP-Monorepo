<?php

class AclAcessoSistema_Model extends WS_Model {

    public function __construct() {
        $this->_db = new AclAcessoSistema_Db();
        $this->_title = 'Gerenciador de Acesso do Sistema';
        $this->_singular = 'Acesso do Sistema';
        $this->_plural = 'Acessos do Sistema';

        parent::__construct();
    }

    public function aclUsuario($usuario_id) {
        $itens = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'modulos'), array('id', 'titulo'))
                ->joinInner(array('mc' => 'modulos_categorias'), 'mc.id = m.categoria_id', array('categoria_id' => 'id', 'categoria'))
                ->joinLeft(array('um' => 'usuarios_modulos'), 'm.id = um.modulo_id AND um.usuario_id = ' . $usuario_id, array('acl_id' => 'id'));
        $itens = $itens->query()->fetchAll();

        if (!empty($itens)):
            foreach ($itens AS $item):
                $modulo = null;
                $modulo['titulo'] = $item['titulo'];
                $modulo['id'] = $item['id'];
                $modulo['acl_id'] = $item['acl_id'];

                $acl[$item['categoria_id']]['categoria'] = $item['categoria'];
                $acl[$item['categoria_id']]['modulos'][] = $modulo;
            endforeach;
            return $acl;
        endif;
    }

    public function cleanPermissions($usuario_id) {
        $where = $this->getDefaultAdapter()->quoteInto('usuario_id = ?', $usuario_id);
        $this->_db->delete($where);
    }

    public function setPermissions($data, $usuario_id) {
        if (!empty($data)):
            foreach ($data AS $modulo_id):
                if (!empty($modulo_id)):
                    $dados['modulo_id'] = $modulo_id;
                    $dados['usuario_id'] = $usuario_id;
                    $this->_db->insere($dados, $this->getOption('actions', 'add'), $this->_db->getTableName());
                endif;
            endforeach;
        endif;
    }

    public function getPermissions($usuario_id) {
        $permissoes = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('um' => 'usuarios_modulos'), array(''))
                ->joinInner(array('m' => 'modulos'), 'm.id = um.modulo_id', array('controller', 'action'))
                ->where('um.usuario_id = ?', $usuario_id);
        return $permissoes->query()->fetchAll();
    }

    public function getPermissionsGroup($usuario_id) {
        $permissoes = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('um' => 'usuarios_modulos'), array(''))
                ->joinInner(array('m' => 'modulos'), 'm.id = um.modulo_id', array(''))
                ->joinInner(array('mc' => 'modulos_categorias'), 'mc.id = m.categoria_id', array('id'))
                ->group('mc.id')
                ->where('um.usuario_id = ?', $usuario_id);
        return $permissoes->query()->fetchAll();
    }

}