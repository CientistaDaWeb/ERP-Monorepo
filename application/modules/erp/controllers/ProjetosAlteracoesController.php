<?php

class Erp_ProjetosAlteracoesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ProjetosAlteracoes_Model();
        if ($this->_hasParam('parent_id')):
            $projeto_id = $this->_getParam('parent_id');
            $this->model->_formFields['projeto_id']['value'] = $projeto_id;
            $this->model->_projeto_id = $projeto_id;
            $this->model->setFormFields();
        endif;

        $auth = new WS_Auth('erp');
        $usuario = $auth->getIdentity();
        if($usuario->papel == 'A'):
            $this->model->_formFields['data']['type'] = 'Date';
            $this->model->_formFields['hora_inicial']['type'] = 'Hour';
            $this->model->_formFields['hora_final']['type'] = 'Hour';
            $this->model->_formFields['usuario_id']['type'] = 'Select';
        endif;

        $this->form = WS_Form_Generator::generateForm('ProjetosAlteracoes', $this->model->getFormFields());
        parent::init();
    }

    public function projetoAction() {
        $projeto_id = $this->_getParam('parent_id');
        $items = $this->model->getByProject($projeto_id);
        $this->view->items = $items;
        $this->view->data['parent_id'] = $projeto_id;
    }

    public function formularioAction() {
        $auth = new WS_Auth('erp');
        $usuario = $auth->getIdentity();

        if (!$this->_hasParam('usuario_id')):
            $this->model->_params['usuario_id'] = $usuario->id;
            $dados['usuario_id'] = $usuario->id;
        endif;

        $projeto_id = $this->_getParam('parent_id');
        if (!empty($projeto_id)):
            $this->model->_params['projeto_id'] = $projeto_id;
            $dados['projeto_id'] = $projeto_id;
        endif;

        if (isset($dados)):
            $this->form->populate($dados);
        endif;

        if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) :
            $upload = new Upload($_FILES['upload']);
            if ($upload->uploaded) :
                $upload->Process(UPLOAD_PATH . 'projetos-alteracoes');

                if ($upload->processed) :
                    $this->model->_params['arquivo'] = $upload->file_dst_name;
                else :
                    $this->_helper->FlashMessenger(array('error' => $upload->error));
                endif;
            else :
                $this->_helper->FlashMessenger(array('error' => $upload->error));
            endif;
        endif;

        parent::formularioAction();
    }

    public function iniciaratividadeAction() {
        $id = $this->_getParam('id');
        if (!empty($id)):
            try {
                $data['id'] = $id;
                $data['hora_inicial'] = date('H:i:s');
                $this->model->_db->atualiza($data, $this->model->_messages['update'], $this->model->_db->getTableName());
                $this->alerta('sucess', 'Alteração de Projeto atualizada com sucesso!');
            } catch (Exception $e) {
                $this->alerta('error', 'Erro ao alterar a Alteração de projeto! ' . $e->getMessage());
            }
        endif;
    }

    public function finalizaratividadeAction() {
        $id = $this->_getParam('id');
        if (!empty($id)):
            try {
                $data['id'] = $id;
                $data['hora_final'] = date('H:i:s');
                $this->model->_db->atualiza($data, $this->model->_messages['update'], $this->model->_db->getTableName());
                $this->alerta('sucess', 'Alteração de Projeto atualizada com sucesso!');
            } catch (Exception $e) {
                $this->alerta('error', 'Erro ao alterar a Alteração de projeto! ' . $e->getMessage());
            }
        endif;
    }

    public function moverppciAction() {
        $id = $this->_getParam('id');
        if (!empty($id)):
            try {
                $dados = $this->model->find($id);
                $ProjetosPpciModel = new ProjetosPpci_Model();
                $ProjetosPpciModel->_db->insere($dados, $ProjetosPpciModel->_messages['insert'], $ProjetosPpciModel->_db->getTableName());

                $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $id);
                $this->model->_db->delete($where);
                $this->alerta('sucess', 'Atividade movida para PPCI! ');
            } catch (Exception $e) {
                $this->alerta('error', 'Erro ao mover a Atividade para PPCI! ' . $e->getMessage());
            }
        endif;
    }
    public function moverhidroAction() {
        $id = $this->_getParam('id');
        if (!empty($id)):
            try {
                $dados = $this->model->find($id);
                $ProjetosHidroModel = new ProjetosHidro_Model();
                $ProjetosHidroModel->_db->insere($dados, $ProjetosHidroModel->_messages['insert'], $ProjetosHidroModel->_db->getTableName());

                $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $id);
                $this->model->_db->delete($where);
                $this->alerta('sucess', 'Atividade movida para Hidro! ');
            } catch (Exception $e) {
                $this->alerta('error', 'Erro ao mover a Atividade para Hidro! ' . $e->getMessage());
            }
        endif;
    }

}