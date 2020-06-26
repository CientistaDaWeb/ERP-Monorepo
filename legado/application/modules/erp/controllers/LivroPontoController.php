<?php

class Erp_LivroPontoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Pontos_Model();
        $this->form = WS_Form_Generator::generateForm('Pontos', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

    public function folhaAction() {
        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            $folha = $this->model->buscaParaFolha($data);

            $items = array();
            if (!empty($folha)):
                foreach ($folha AS $item):
                    $items[$item['data']][] = $item;
                endforeach;
            endif;

            $this->view->mes = $data['mes'];
            $this->view->ano = $data['ano'];
            $this->view->usuario_id = $data['usuario_id'];
            $this->view->items = $items;
        endif;
    }

    public function salvaDadosAction() {
        if ($this->_request->isPost()):
            $data = $this->_getAllParams();
            $this->model->limpaPeriodo($data);

            foreach ($data['pontos'] AS $item):
                $dados = array();
                $dados['data'] = $item['data'];
                $dados['usuario_id'] = $data['usuario_id'];
                if (!empty($item['manha']['entrada']) && !empty($item['manha']['saida'])):
                    $dados['hora'] = $item['manha']['entrada'];
                    $this->model->_db->insere($dados, $this->model->getOption('messages', 'add'), $this->model->_db->getTableName());

                    $dados['hora'] = $item['manha']['saida'];
                    $this->model->_db->insere($dados, $this->model->getOption('messages', 'add'), $this->model->_db->getTableName());
                endif;
                if (!empty($item['tarde']['entrada']) && !empty($item['tarde']['saida'])):
                    $dados['hora'] = $item['tarde']['entrada'];
                    $this->model->_db->insere($dados, $this->model->getOption('messages', 'add'), $this->model->_db->getTableName());

                    $dados['hora'] = $item['tarde']['saida'];
                    $this->model->_db->insere($dados, $this->model->getOption('messages', 'add'), $this->model->_db->getTableName());
                endif;
            endforeach;
            $this->alerta('sucess', 'Ponto atualizado');
        endif;
        exit();
    }

}
