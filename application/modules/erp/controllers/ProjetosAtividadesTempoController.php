<?php

class Erp_ProjetosAtividadesTempoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ProjetosAtividadesTempo_Model();
        $this->form = WS_Form_Generator::generateForm('ProjetosAtividadesTempo', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {

        if ($this->_hasParam('projeto_atividade_id')):
            $ProjetosAtividadesModel = new ProjetosAtividades_Model();
            $dados = array();
            $dados['id'] = $this->_getParam('projeto_atividade_id');
            $tarefa_concluida = $this->_getParam('tarefa_concluida');
            if ($tarefa_concluida == 'S'):
                $dados['status'] = 'C';
            else:
                $dados['status'] = 'P';
            endif;
            $ProjetosAtividadesModel->_db->atualiza($dados, $ProjetosAtividadesModel->getOption('messages', 'update'), $ProjetosAtividadesModel->_db->getTableName());
        endif;

        parent::formularioAction();
    }

    public function iniciarAction() {
        $atividade_id = $this->_getParam('id');
        $retorno = $this->model->iniciar($atividade_id);
        $this->alerta($retorno['tipo'], $retorno['mensagem']);
    }

    public function pararAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);
        $data['data'] = WS_Date::adjustToView($item['data']);
        $date1 = $item['data'] . ' ' . $item['hora'];
        $date2 = date('Y-m-d H:i:s');
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $seconds_diff = $ts2 - $ts1;

        $diferenca = floor($seconds_diff / 60);
        $data['id'] = $item['id'];
        $data['hora'] = $item['hora'];
        $data['minutos'] = $diferenca;
        $data['projeto_atividade_id'] = $item['projeto_atividade_id'];
        $this->form->populate($data);
    }

}
