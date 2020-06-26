<?php

class Erp_AclAcessoSistemaController extends Erp_Controller_Action {

    public function init() {
        $this->model = new AclAcessoSistema_Model();
        parent::init();
    }

    public function formularioAction() {
        $usuario_id = $this->_getParam('parent_id');
        if (!empty($usuario_id)):
            $usuarioDb = new Usuarios_Model();
            $usuario = $usuarioDb->find($usuario_id);
            if (!empty($usuario)):
                $this->view->usuario = $usuario;
            endif;

            $this->view->modulos = $this->model->aclUsuario($usuario_id);
            $this->model->_params['usuario_id'] = $usuario_id;
            $aclAcesso = new AclAcessoSistema_Model();

            if ($this->_request->isPost()):
                $data = $this->_getParam('modulo_id');
                try {
                    $aclAcesso->cleanPermissions($usuario_id);
                    $aclAcesso->setPermissions($data, $usuario_id);
                    $this->alerta('sucess', 'Permissões setadas com sucesso!');
                } catch (Exception $e) {
                    $this->alerta('error', $e->getMessage());
                }
            endif;
        endif;
    }

}

