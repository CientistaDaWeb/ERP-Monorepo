<?php

class Erp_OrdensServicoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new OrdensServico_Model();
        $this->form = WS_Form_Generator::generateForm('OrdensServico', $this->model->getFormFields());
        unset($this->buttons['add']);

        if ($this->_request->getActionName() == 'visualizar'):
            $this->noLogin = true;
        endif;
        if ($this->_request->getActionName() == 'relatorio'):
            $this->noLogin = true;
        endif;

        parent::init();
    }

    public function formularioAction() {
        $this->options['noList'] = true;
        $this->model->_params['transportador_id'] = 1;
        $orcamento_id = $this->_getParam('parent_id');
        if (!empty($orcamento_id)):
            $this->model->_params['orcamento_id'] = $orcamento_id;
            $id = $this->_getParam('id');
            if (empty($id)):
                $sequencial = $this->model->getSequencial($orcamento_id);
                if (!empty($sequencial)):
                    $this->model->_params['sequencial'] = $sequencial['sequencial'] + 1;
                else:
                    $this->model->_params['sequencial'] = 1;
                endif;
            endif;

            $OrcamentoModel = new Orcamentos_Model();
            $orcamento = $OrcamentoModel->find($orcamento_id);
            $cliente_id = $orcamento['cliente_id'];
        endif;

        parent::formularioAction();

        if (!empty($this->view->data['orcamento_id'])):
            $OrcamentoModel = new Orcamentos_Model();
            $orcamento = $OrcamentoModel->find($this->view->data['orcamento_id']);
            $cliente_id = $orcamento['cliente_id'];
        endif;

        if (!empty($cliente_id)):
            $ClientesEnderecosModel = new ClientesEnderecos_Model();
            $enderecos = $ClientesEnderecosModel->fetchPair($cliente_id);
            $this->model->_formFields['endereco_id']['options'] = $enderecos;
            $this->form = WS_Form_Generator::generateForm('OrdensServico', $this->model->getFormFields());
            $this->form->populate($this->view->data);
            $this->view->form = $this->form;
        endif;
    }

    public function orcamentoAction() {
        $orcamento_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorOrcamento($orcamento_id);
        $this->view->items = $items;
    }

    public function arquivosAction() {
        $id = $this->_getParam('parent_id');
        $arquivo = UPLOAD_PATH . 'ordem-servico/OS_' . $id . '.pdf';
        if (is_file($arquivo)):
            $dados = stat($arquivo);
            $this->view->visualizacao_gerado = $dados[9];
            $this->view->visualizacao_arquivo = 'OS_' . $id . '.pdf';
        endif;

        $arquivo = UPLOAD_PATH . 'ordem-servico/Relatorio_' . $id . '.pdf';
        if (is_file($arquivo)):
            $dados = stat($arquivo);
            $this->view->relatorio_gerado = $dados[9];
            $this->view->relatorio_arquivo = 'Relatorio_' . $id . '.pdf';
        endif;

        $TextosModel = new Textos_Model();
        $this->view->templates_mensagem = $TextosModel->getByCategoria(9);
        $this->view->templates_assunto = $TextosModel->getByCategoria(10);

        $data = $this->model->find($id);
        $OrcamentosModel = new Orcamentos_Model();
        $orcamento = $OrcamentosModel->find($data['orcamento_id']);

        $ClientesModel = new Clientes_Model();
        $cliente = $ClientesModel->find($orcamento['cliente_id']);
        $this->view->cliente = $cliente;

        $this->view->id = $id;
    }

    public function enviaarquivosAction() {
        try {
            $data = $this->_getAllParams();

            $mail = new Email_Model('utf-8');

            $this->view->conteudo = $data;
            $body = $this->view->render('emails/ordem_servico.phtml');

            $mail->setBodyHtml($body, 'utf-8');
            $mail->setSubject(utf8_decode($data['assunto']));
            $mail->setReplyTo('acquasana@acquasana.com.br');

            $destinatarios = explode(';', $data['email']);
            foreach ($destinatarios AS $destinatario):
                $mail->addTo($destinatario);
            endforeach;
            //$mail->addBcc('acquasana@acquasana.com.br');

            foreach ($data['arquivos'] AS $file):
                $arquivo = realpath(UPLOAD_PATH . 'ordem-servico/' . $file);

                $at = new Zend_Mime_Part(file_get_contents($arquivo));
                $at->type = 'application/pdf';
                $at->disposition = Zend_Mime::DISPOSITION_INLINE;
                $at->encoding = Zend_Mime::ENCODING_BASE64;
                $at->filename = $file;

                $mail->addAttachment($at);
            endforeach;
            $mail->envia('acquasana@acquasana.com.br', 'Acquasana');
            $this->alerta('sucess', 'E-mail enviado com sucesso!');
        } catch (Zend_Mail_Exception $e) {
            $this->alerta('error', $e->getMessage());
        }
        exit();
    }

    public function faturarAction() {
        $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $this->_getParam('id'));
        $data['faturado'] = 'S';
        $this->model->_db->update($data, $where);
    }

    public function contasreceberAction() {
        $conta_id = $this->_getParam('parent_id');
        $ContasReceberModel = new ContasReceber_Model();
        $conta = $ContasReceberModel->find($conta_id);

        $items = $this->model->buscarPorCliente($conta['cliente_id'], true);
        $this->view->items = $items;

        $selecionados = $this->model->buscarPorConta($conta_id);
        $this->view->selecionados = $selecionados;
    }

    public function visualizarAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);

        $ServicosModel = new Servicos_Model();
        $servicos = $ServicosModel->buscarPorOrdemServico($id);

        $EmpresasModel = new Empresas_Model();
        $empresa = $EmpresasModel->find($item['empresa_id']);

        $ClientesEnderecosModel = new ClientesEnderecos_Model();
        $endereco = $ClientesEnderecosModel->find($item['endereco_id']);

        $ClientesTelefonesModel = new ClientesTelefones_Model();
        $telefones = $ClientesTelefonesModel->buscarPorCliente($item['cliente_id']);

        $OrdemServicoImagensModel = new OrdemServicoImagens_Model();
        $imagens = $OrdemServicoImagensModel->getByOS($id, 'V');

        $this->view->ordemServico = $item;
        $this->view->empresa = $empresa;
        $this->view->endereco = $endereco;
        $this->view->telefones = $telefones;
        $this->view->servicos = $servicos;
        $this->view->imagens = $imagens;
        $this->view->noLogo = true;
    }

    public function relatorioAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);

        $EmpresasModel = new Empresas_Model();
        $empresa = $EmpresasModel->find($item['empresa_id']);


        $ServicosModel = new Servicos_Model();
        $servicos = $ServicosModel->buscarPorOrdemServico($id);

        $ClientesEnderecosModel = new ClientesEnderecos_Model();
        $endereco = $ClientesEnderecosModel->find($item['endereco_id']);

        $ClientesTelefonesModel = new ClientesTelefones_Model();
        $telefones = $ClientesTelefonesModel->buscarPorCliente($item['cliente_id']);

        $OrdemServicoImagensModel = new OrdemServicoImagens_Model();
        $imagens = $OrdemServicoImagensModel->getByOS($id, 'R');

        $this->view->empresa = $empresa;
        $this->view->ordemServico = $this->model->adjustToView($item);
        $this->view->endereco = $endereco;
        $this->view->telefones = $telefones;
        $this->view->servicos = $servicos;
        $this->view->imagens = $imagens;
        $this->view->noLogo = true;
    }

    public function clienteAction() {
        $cliente_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

    public function addcontareceberAction() {
        $conta_id = $this->_getParam('parent_id');
        if (!empty($conta_id)):
            if ($this->_request->isPost()):
                $ContasReceberOrdemServicoModel = new ContasReceberOrdensServicos_Model();
                $ContasReceberOrdemServicoModel->limpaConta($conta_id);
                $data = $this->_request->getPost();

                try {
                    $dados['conta_receber_id'] = $conta_id;
                    foreach ($data['os_id'] AS $os) {
                        $dados['ordem_servico_id'] = $os;
                        $ContasReceberOrdemServicoModel->addConta($dados);
                    }
                    $this->alerta('sucess', 'Ordens de Serviço adicionadas a Conta a Receber.');
                } catch (Exception $e) {
                    $this->alerta('error', $e->getMessage());
                }
            endif;
        endif;
        exit();
    }

}
