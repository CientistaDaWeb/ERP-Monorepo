<?php

class Erp_RelatorioClientesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Clientes_Model();
        parent::init();
        $this->model->_title = 'Relatório de Clientes';
    }

    public function indexAction() {
        $items = $this->model->relatorio();
        $this->view->items = $items;
    }

    public function etiquetasAction() {
        $data = $this->_getAllParams();
        if (!empty($data['cliente_id'])):
            $this->view->clientes = $data['cliente_id'];
        endif;
    }

    public function imprimeetiquetasAction() {
        $data = $this->_getAllParams();
        if (!empty($data['endereco_id'])):
            foreach ($data['endereco_id'] AS $endereco):
                $ClientesEnderecos = new ClientesEnderecos_Model();
                $enderecos[] = $ClientesEnderecos->buscaPorId($endereco);
            endforeach;
            $this->view->usadas = $data['usadas'];
            $this->view->enderecos = $enderecos;
        endif;
    }

}