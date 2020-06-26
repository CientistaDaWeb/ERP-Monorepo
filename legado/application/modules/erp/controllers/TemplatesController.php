<?php

class Erp_TemplatesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Templates_Model();
        if ($this->_hasParam('parent_id')):
            $categoria_id = $this->_getParam('parent_id');
            $this->model->_formFields['categoria_id']['value'] = $categoria_id;
        endif;
        $this->form = WS_Form_Generator::generateForm('Templates', $this->model->getFormFields());
        parent::init();
    }

    public function categoriaAction() {
        $categoria_id = $this->_getParam('parent_id');
        $items = $this->model->getByCategory($categoria_id);
        $this->view->items = $items;
        $this->view->data['parent_id'] = $categoria_id;
    }

    public function formularioAction() {
        $categoria_id = $this->_getParam('parent_id');
        if (!empty($categoria_id)):
            $this->model->_params['categoria_id'] = $categoria_id;
        endif;

        parent::formularioAction();
    }

    public function adicionarTemplateAction() {
        $dados = $this->_getAllParams();
        $categoria_id = $dados['parent_id'];
        $projeto_id = $dados['id'];

        $templates = $this->model->getByCategory($categoria_id);

        $ProjetosAtividadeModel = new ProjetosAtividades_Model();

        if (!empty($templates)):
            try {
                foreach ($templates AS $template):
                    $atividade = null;
                    $atividade['created'] = date('Y-m-d H:i:s');
                    $atividade['projeto_id'] = $projeto_id;
                    $atividade['nome'] = $template['nome'];
                    $atividade['descricao'] = $template['descricao'];
                    $atividade['pontos'] = $template['pontos'];
                    $atividade['status'] = 'P';
                    $atividade['categoria_id'] = $template['categoria_id'];


                    $ProjetosAtividadeModel->_db->insert($atividade, $ProjetosAtividadeModel->getOption('messages', 'add'), $ProjetosAtividadeModel->_db->getTableName());
                endforeach;
                $this->alerta('sucess', 'Atividades inseridas com sucesso!');
            } catch (Exception $e) {
                $this->alerta('error', $e->getMessage());
            }
        else:
            $this->alerta('error', 'Nenhum template encontrado!');
        endif;
    }

}