<?php

class Erp_RelatorioProjetosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Projetos_Model();
        parent::init();
        $this->model->_title = 'Relatório de Projetos';
    }

    public function indexAction() {
        $data['usuario_id'] = '';
        $data['projeto_id'] = '';
        $data['categoria_id'] = '';
        $data['construtora_id'] = '';
        $data['arquiteto_id'] = '';
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
        $data['data_final'] = date('d/m/Y');

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            /* Limita a data final da pesquisa quando não for administrador */
            $auth = new WS_Auth('erp');
            $user = $auth->getIdentity();
            if ($user->papel != 'A'):
                /* Limita a data inicial */
                $data = Erp_Date::dateLimit($data, 35, 'data_inicial');
            endif;

            $items = $this->model->relatorio($data);
            $this->view->items = $items;
            $ProjetosPpciModel = new ProjetosPpci_Model();
            $ProjetosHidroModel = new ProjetosHidro_Model();
            $ppcis = array();
            $hidros = array();
            $projeto_ids = array();
            foreach ($items AS $projeto):
                $projeto_ids[] = $projeto['id'];
            endforeach;
            $ppcis = $ProjetosPpciModel->relatorio($projeto_ids, $data);
            $hidros = $ProjetosHidroModel->relatorio($projeto_ids, $data);
            $this->view->ppcis = $ppcis;
            $this->view->hidros = $hidros;
        endif;

        $this->view->data = $data;
    }

}