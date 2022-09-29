<?php

class Erp_ClientesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Clientes_Model();
        $this->form = WS_Form_Generator::generateForm('Clientes', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        $this->options['noList'] = true;

        parent::formularioAction();

        if (isset($this->view->data['documento_tipo'])):
            if ($this->view->data['documento_tipo'] == '2'):
                $this->model->_formFields['documento']['type'] = 'Cpf';
                $this->form = WS_Form_Generator::generateForm('Clientes', $this->model->getFormFields());
                $this->form->populate($this->view->data);
                $this->view->form = $this->form;
            endif;
        endif;

        if (!isset($this->view->data['usuario'])):
            $this->view->data['usuario'] = $this->model->gerarandomico();
            $this->view->data['senha'] = $this->model->gerarandomico();
            $this->form->populate($this->view->data);
            $this->view->form = $this->form;
        endif;

        if ($this->_hasParam('id')):
            $ClientesEnderecos = new ClientesEnderecos_Model();
            $this->view->enderecos = $ClientesEnderecos->fetchPair($this->_getParam('id'));
        endif;
    }

    public function arAction() {
        if ($this->_hasParam('id')):
            $EmpresaModel = new Empresas_Model();
            $empresa = $EmpresaModel->find(1);
            $EstadosModel = new Estados_Model();
            $estado = $EstadosModel->find($empresa['estado_id']);
            $empresa['uf'] = $estado['uf'];
            $this->view->empresa = $empresa;
            $id = $this->_getParam('id');
            $cliente = $this->model->find($id);
            $endereco_id = $this->_getParam('parent_id');
            $ClientesEnderecos = new ClientesEnderecos_Model();
            $endereco = $ClientesEnderecos->find($endereco_id);
            $estado = $EstadosModel->find($endereco['estado_id']);
            $endereco['uf'] = $estado['uf'];
            $cliente['endereco'] = $endereco;
            $cliente['endereco']['pais'] = 'BRASIL';
            $this->view->cliente = $cliente;

        endif;
    }

    public function jsonAction() {
        if ($this->_hasParam('id')):
            $id = $this->_getParam('id');
            $retorno = $this->model->find($id);
            $endereco_id = $this->_getParam('parent_id');
            $ClienteEnderecosModel = new ClientesEnderecos_Model();
            $endereco = $ClienteEnderecosModel->buscaPorId($endereco_id);
            $retorno['endereco'] = $endereco['endereco'];
            $retorno['numero'] = $endereco['numero'];
            $retorno['municipio'] = $endereco['municipio'];
            $retorno['cnpj'] = $retorno['documento'];
            $retorno['uf'] = $endereco['uf'];
            $retorno['cep'] = $endereco['cep'];

            $ClienteTelefonesModel = new ClientesTelefones_Model();
            $telefones = $ClienteTelefonesModel->buscarPorCliente($id);
            $retorno['telefone'] = $telefones[0]['telefone'];

            $item[] = $retorno;
            echo Zend_Json::encode($item);
        endif;
        exit();
    }

    public function mapaAction() {
        $ClienteEnderecosModel = new ClientesEnderecos_Model();
        $enderecos = $ClienteEnderecosModel->listagemMapa();
        $this->view->enderecos = $enderecos;
    }

}
