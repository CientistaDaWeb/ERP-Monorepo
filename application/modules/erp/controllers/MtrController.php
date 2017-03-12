<?php

class Erp_MtrController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Mtr_Model();
        $this->form = WS_Form_Generator::generateForm('Mtr', $this->model->getFormFields());
        unset($this->buttons['add']);
        parent::init();
    }

    public function formularioAction() {
        $ordem_servico_id = $this->_getParam('parent_id');

        $mtr_id = $this->_getParam('id');
        if (!empty($mtr_id)):
            $mtr = $this->model->find($mtr_id);
            $ordem_servico_id = $mtr['ordem_servico_id'];
        endif;

        if (!empty($ordem_servico_id)):
            $this->model->_params['ordem_servico_id'] = $ordem_servico_id;
            $OrdensServicoModel = new OrdensServico_Model();
            $ordemServico = $OrdensServicoModel->find($ordem_servico_id);
            $cliente_id = $ordemServico['cliente_id'];
        endif;


        if (!empty($cliente_id)):
            $ClientesEnderecosModel = new ClientesEnderecos_Model();

            $enderecos = $ClientesEnderecosModel->fetchPair($cliente_id);
            $this->model->_formFields['endereco_id']['options'] = $enderecos;
            $this->form = WS_Form_Generator::generateForm('Mtr', $this->model->getFormFields());
        endif;
        parent::formularioAction();
    }

    public function ordemservicoAction() {
        $ordem_servico_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorOrdemServico($ordem_servico_id);
        $this->view->items = $items;
    }

    public function formularioimpressaoAction() {
        $data = $this->_getAllParams();

        $auth = new WS_Auth('erp');
        $usuario = $auth->getIdentity();

        if (!empty($data['id'])):
            $MtrDadosModel = new MtrDados_Model();
            $mtr_dados = $MtrDadosModel->buscaPorMtr($data['id']);
            if (!empty($mtr_dados)):
                $dados['id'] = $mtr_dados['id'];
                $dados['mtr_id'] = $mtr_dados['mtr_id'];
                $dados['gerador']['razao_social'] = $mtr_dados['gerador_razao_social'];
                $dados['gerador']['cnpj'] = $mtr_dados['gerador_cnpj'];
                $dados['responsavel']['gerador'] = $mtr_dados['responsavel_gerador'];
                $dados['gerador']['lo'] = $mtr_dados['gerador_lo'];
                $dados['gerador']['endereco'] = $mtr_dados['gerador_endereco'];
                $dados['gerador']['municipio'] = $mtr_dados['gerador_municipio'];
                $dados['gerador']['responsavel'] = $mtr_dados['gerador_responsavel'];
                $dados['gerador']['telefone'] = $mtr_dados['gerador_telefone'];
                $dados['gerador']['ramal'] = $mtr_dados['gerador_ramal'];

                $dados['residuos'] = $mtr_dados['residuos'];
                $dados['quantidade'] = $mtr_dados['quantidade'];

                $dados['transportador']['razao_social'] = $mtr_dados['transportador_razao_social'];
                $dados['transportador']['cnpj'] = $mtr_dados['transportador_cnpj'];
                $dados['responsavel']['transportador'] = $mtr_dados['responsavel_transportador'];
                $dados['transportador']['endereco'] = $mtr_dados['transportador_endereco'];
                $dados['transportador']['cep'] = $mtr_dados['transportador_cep'];
                $dados['transportador']['municipio'] = $mtr_dados['transportador_municipio'];
                $dados['transportador']['fone'] = $mtr_dados['transportador_fone'];
                $dados['transportador']['equipamento'] = $mtr_dados['transportador_equipamento'];
                $dados['transportador']['condutor'] = $mtr_dados['transportador_condutor'];
                $dados['transportador']['condutor_cpf'] = $mtr_dados['transportador_condutor_cpf'];
                $dados['transportador']['lo'] = $mtr_dados['transportador_lo'];
                $dados['transportador']['lacre'] = $mtr_dados['transportador_lacre'];
                $dados['transportador']['veiculo'] = $mtr_dados['transportador_veiculo'];
                $dados['transportador']['placa'] = $mtr_dados['transportador_placa'];
                $dados['transportador']['estado'] = $mtr_dados['transportador_estado'];

                $dados['destinatario']['razao_social'] = $mtr_dados['destinatario_razao_social'];
                $dados['destinatario']['cnpj'] = $mtr_dados['destinatario_cnpj'];
                $dados['responsavel']['receptor'] = $mtr_dados['responsavel_receptor'];
                $dados['instalacao']['receptor'] = $mtr_dados['instalacao_receptor'];
                $dados['destinatario']['lo'] = $mtr_dados['destinatario_lo'];
                $dados['destinatario']['endereco'] = $mtr_dados['destinatario_endereco'];
                $dados['destinatario']['cep'] = $mtr_dados['destinatario_cep'];
                $dados['destinatario']['municipio'] = $mtr_dados['destinatario_municipio'];
                $dados['destinatario']['uf'] = $mtr_dados['destinatario_uf'];
                $dados['destinatario']['fone'] = $mtr_dados['destinatario_fone'];
                $dados['destinatario']['motivo'] = $mtr_dados['destinatario_motivo'];
                $dados['destinatario']['fepam'] = $mtr_dados['destinatario_fepam'];
                $dados['destinatario']['responsavel'] = $mtr_dados['destinatario_responsavel'];
                $dados['destinatario']['fone'] = $mtr_dados['destinatario_fone'];
                $dados['destinatario']['email'] = $mtr_dados['destinatario_email'];

                $dados['descricao'] = $mtr_dados['descricao'];
                $dados['instrucoes'] = $mtr_dados['instrucoes'];
                $dados['discrepancia'] = $mtr_dados['discrepancia'];
            else:
                $mtr = $this->model->buscaDadosImpressao($data['id']);
                $EmpresasModel = new Empresas_Model();
                $empresa = $EmpresasModel->find(2);

                $dados['mtr_id'] = $data['id'];
                $dados['gerador']['razao_social'] = $dados['responsavel']['gerador'] = $mtr['gerador'];
                $dados['gerador']['cnpj'] = $mtr['gerador_cnpj'];
                $dados['gerador']['lo'] = $mtr['gerador_lo'];
                $dados['gerador']['endereco'] = $mtr['gerador_endereco'];
                $dados['gerador']['municipio'] = $mtr['gerador_municipio'];
                $dados['gerador']['responsavel'] = $mtr['gerador_responsavel'];
                $dados['gerador']['telefone'] = $mtr['gerador_telefone'];
                $dados['gerador']['ramal'] = '';

                $dados['residuos'] = '';
                $dados['quantidade'] = '';

                $dados['transportador']['razao_social'] = $dados['responsavel']['transportador'] = $mtr['transportador'];
                $dados['transportador']['cnpj'] = $mtr['transportador_cnpj'];
                $dados['transportador']['endereco'] = $mtr['transportador_endereco'];
                $dados['transportador']['municipio'] = $mtr['transportador_municipio'];
                $dados['transportador']['cep'] = $mtr['transportador_cep'];
                $dados['transportador']['fone'] = $mtr['transportador_fone'];
                $dados['transportador']['equipamento'] = 'FORD CARGO 2429 (TANQUE)';
                $dados['transportador']['condutor'] = 'DORIVAL RAZIA';
                $dados['transportador']['condutor_cpf'] = '669.353.000-10';
                $dados['transportador']['lo'] = $mtr['transportador_lo'];
                $dados['transportador']['lacre'] = '';
                $dados['transportador']['veiculo'] = '';
                $dados['transportador']['placa'] = 'IUL 5964';
                $dados['transportador']['estado'] = $mtr['transportador_estado'];

                $dados['destinatario']['razao_social'] = $dados['responsavel']['receptor'] = $dados['instalacao']['receptor'] = $empresa['razao_social'];
                $dados['destinatario']['cnpj'] = $empresa['documento'];
                $dados['destinatario']['lo'] = $empresa['numero_fepan'];
                $dados['destinatario']['endereco'] = $empresa['endereco'] . ', ' . $empresa['numero'] . ' - ' . $empresa['complemento'];
                $dados['destinatario']['fone'] = $empresa['telefone'];
                $dados['destinatario']['cep'] = $empresa['cep'];
                $dados['destinatario']['municipio'] = $empresa['municipio'];
                $dados['destinatario']['uf'] = $empresa['uf'];
                $dados['destinatario']['motivo'] = '';
                $dados['destinatario']['fepam'] = '';
                $dados['destinatario']['email'] = '';
                $dados['destinatario']['responsavel'] = $usuario->nome;

                $dados['descricao'] = '';
                $dados['instrucoes'] = 'As instruções ao motororista em caso de emergência encontram-se descritas exclusivamente no envelope para transporte. O motorista deve comunicar a emergência ao destinatário.';
                $dados['discrepancia'] = '';
            endif;
            $this->view->data = $dados;
        endif;
    }

    public function imprimirmtrAction() {
        $data = $this->_request->getPost();

        $MtrDadosModel = new MtrDados_Model();
        if (!empty($data['id'])):
            $data['created'] = date('Y-m-d H:i:s');
            $MtrDadosModel->_db->atualiza($data, $MtrDadosModel->getOption('actions', 'update'), $MtrDadosModel->_db->getTableName());
        else:
            $MtrDadosModel->_db->insere($data, $MtrDadosModel->getOption('actions', 'add'), $MtrDadosModel->_db->getTableName());
        endif;

        $MtrModel = new Mtr_Model();
        $residuos = $MtrModel->getOption('residuos', $data['residuos']);
        $data['residuos'] = $residuos;
        $this->view->data = $data;
    }

}
