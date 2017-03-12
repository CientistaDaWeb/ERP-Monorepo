<?php

class Erp_CertificadosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Certificados_Model();
        $this->form = WS_Form_Generator::generateForm('Certificados', $this->model->getFormFields());
        unset($this->buttons['add']);

        if ($this->_request->getActionName() == 'visualizar'):
            $this->noLogin = true;
        endif;
        if ($this->_request->getActionName() == 'cron'):
            $this->noLogin = true;
        endif;
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        $this->view->mtr_id = $mtr_id = $this->_getParam('parent_id');
        if (!empty($mtr_id)):
            $id = $this->model->geraCertificado($mtr_id);
            $this->view->data['id'] = $id;
            if (empty($id)):
                $this->alerta('error', 'Erro ao buscar os dados para o certificado!');
            endif;
        else:
            if ($this->_hasParam('id')):
                $id = $this->_getParam('id');
            endif;
        endif;


        if (!empty($id)):
            $item = $this->model->find($id);
            $this->model->_params = $item;
            $this->view->data['orcamento_id'] = $item['orcamento_id'];

            $arquivo = UPLOAD_PATH . 'certificados/Certificado_' . $item['orcamento_id'] . '_' . $item['id'] . '.pdf';
            if (is_file($arquivo)):
                $dados = stat($arquivo);
                $this->view->pdf_gerado = $dados[9];
                $this->view->pdf = 'Certificado_' . $item['orcamento_id'] . '_' . $item['id'] . '.pdf';
            endif;
        endif;

        parent::formularioAction();
    }

    public function gerarpdfAction() {
        $id = $this->_getParam('id');
        try {
            $this->model->gerarPdf($id);
            $this->alerta('sucess', 'PDF do certificado gerado!');
        } catch (Exception $e) {
            $this->alerta('error', $e->getMessage());
        }
    }

    public function verpdfAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);

        $arquivo = 'Certificado_' . $item['orcamento_id'] . '_' . $item['id'] . '.pdf';
        $document = file_get_contents(UPLOAD_PATH . 'certificados/' . $arquivo);

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $this->getResponse()
                ->setHeader('Content-Disposition', 'attachment; filename=' . $arquivo)
                ->setHeader('Content-type', 'application/x-pdf')
                ->setBody($document);
    }

    public function lembretepesquisaAction() {
        $id = $this->_getParam('id');
        $dados = $this->model->buscarDadosEmail($id);
        $dados['certificado'] = $dados['orcamento_id'] . '.' . $dados['sequencial'];
        $dados['codigo'] = base64_encode($dados['id']);

        try {
            $mail = new Email_Model('UTF-8');

            $this->view->conteudo = $dados;
            $body = $this->view->render('emails/lembrar-pesquisa.phtml');

            $mail->addTo($dados['email']);
//            $mail->addTo('fernando@webscientist.com.br');
//            $mail->addTo('acquasana@acquasana.com.br');
            $mail->setBodyHtml($body, 'utf-8');
            $mail->setSubject(utf8_decode('Pesquisa de Satisfação - Certificado ' . $dados['certificado']));
            $mail->addBcc('acquasana@acquasana.com.br');
            $mail->addBcc('fernando@webscientist.com.br');
            $mail->setReplyTo('acquasana@acquasana.com.br');

            $mail->envia('acquasana@acquasana.com.br', 'Acquasana');

            $this->alerta('sucess', 'E-mail enviado com sucesso!');
        } catch (Zend_Mail_Exception $e) {
            $this->alerta('error', $e->getMessage());
        }
        exit();
    }

    public function cronAction() {
        $certificados = $this->model->buscaParaCron();
        if (!empty($certificados)):
            foreach ($certificados AS $certificado):
                $dados = $this->model->buscarDadosEmail($certificado['id']);
                $dados['certificado'] = $dados['orcamento_id'] . '.' . $dados['sequencial'];
                $dados['codigo'] = base64_encode($dados['id']);

                try {
                    $mail = new Email_Model('UTF-8');

                    $this->view->conteudo = $dados;
                    $body = $this->view->render('emails/lembrar-pesquisa.phtml');

                    $mail->addTo($dados['email_pesquisa']);
//                        $mail->addTo('fernando@webscientist.com.br');
                    $mail->setBodyHtml($body, 'utf-8');
                    $mail->setSubject(utf8_decode('Pesquisa de Satisfação - Certificado ' . $dados['certificado']));
                    $mail->addBcc('acquasana@acquasana.com.br');
                    $mail->setReplyTo('acquasana@acquasana.com.br');

                    $mail->envia('acquasana@acquasana.com.br', 'Acquasana');

                    echo 'E-mail enviado com sucesso para ' . $dados['contato'] . '!' . "/n";
                } catch (Zend_Mail_Exception $e) {
                    echo 'Erro ao enviar o email para error' . $dados['contato'] . ' / ' . $e->getMessage() . "/n";
                }
            endforeach;
        else:
            echo 'Nenhum certificado para enviar!' . "/n";
        endif;
        echo 'Tarefa finalizada ' . date('d/m/Y H:i:s') . "/n";
        exit();
    }

    public function enviaremailAction() {
        $form = $this->view->form = new Certificados_FormEmail();
        $id = $this->_getParam('id');
        $dados = $this->model->buscarDadosEmail($id);
        $data = $this->_getAllParams();

        if ($this->_request->isPost()):
            if ($this->_hasParam('destinatarios')):
                if ($form->isValid($this->_request->getPost())) :
                    if (date('H') > 12):
                        $saudacao = 'Boa tarde';
                    else:
                        $saudacao = 'Bom dia';
                    endif;

                    $WD = new WS_Date();

                    $remetente_id = $this->_getParam('remetente');
                    if (!empty($remetente_id)):
                        $UsuariosModel = new Usuarios_Model();
                        $usuario = $UsuariosModel->find($remetente_id);
                        if (!empty($usuario)):
                            $dados['nome'] = $usuario['nome'];
                            $dados['telefone'] = $usuario['telefone'];
                            $dados['emailf'] = $usuario['email'];
                        endif;
                    endif;

                    if (!empty($dados['usuario'])):
                        $emailConteudo['descricao'] = '<p>' . $saudacao . ', ' . $dados['contato'] . '</p>
                            <p>Está disponível em nosso site o Certificado de Tratamento do efluente coletado em sua edificação no dia ' . WS_Date::adjustToView($dados['data_coleta']) . '</p>
                    <p>Acesse nosso site (<a href="http://www.acquasana.com.br">http://www.acquasana.com.br</a>) e, na área restrita, digite no login: ' . $dados['usuario'] . ' e na senha: ' . $dados['senha'] . '.</p>
                    <p>Imprima o certificado e arquive-o, pois ele é o comprovante que o efluente retirado teve uma destinação final adequada e legal.</p>';
                        if (!empty($data['descricao'])):
                            $emailConteudo['descricao'] .= '<p>' . nl2br($data['descricao']) . '</p>';
                        endif;
                        $emailConteudo['descricao'] .= '<p>Qualquer dúvida estamos à disposição.</p>
                    <p>Att,<br />
                    ' . $dados['nome'] . '<br />
                    Rua 03 de Outubro 40 | sala 02 |  2. Andar<br />
                    CEP: 95700-000  |  Bento Gonçalves-RS<br />
                    Fone: ' . $dados['telefone'] . '</p>
                    <p>Email: <a href="mailto:' . $dados['emailf'] . '">' . $dados['emailf'] . '</a><br />
                    Site: <a href="http://www.acquasana.com.br">http://www.acquasana.com.br</a></p>';

                        try {
                            $mail = new Email_Model('UTF-8');

                            $this->view->conteudo = $emailConteudo;
                            $body = $this->view->render('emails/certificado.phtml');

                            $mail->setBodyHtml($body, 'utf-8');
                            $mail->setSubject($data['assunto'] . ' (' . $dados['orcamento_id'] . '-' . $dados['sequencial'] . ')');
                            $destinatarios = explode(';', $data['destinatarios']);

                            foreach ($destinatarios AS $destinatario):
                                $mail->addTo($destinatario);
                            endforeach;

                            $mail->addBcc('acquasana@acquasana.com.br');
                            $mail->setReplyTo('acquasana@acquasana.com.br');

                            $mail->envia('acquasana@acquasana.com.br', 'Acquasana');

                            $ClientesCrmModel = new ClientesCrm_Model();
                            $WD = new WS_Date();
                            $novaData = $WD->addMonth(11);

                            $auth = new WS_Auth('erp');
                            $usuario = $auth->getIdentity();

                            $atd['cliente_id'] = $dados['cliente_id'];
                            $atd['usuario_id'] = $usuario->id;
                            $atd['created'] = date('Y-m-d H:i:s');
                            $atd['data'] = date('Y-m-d');
                            $atd['descricao'] = 'Enviou o Certificado ' . $dados['orcamento_id'] . '-' . $dados['sequencial'] . ' por e-mail.';
                            $atd['status'] = 'R';
                            $ClientesCrmModel->_db->insert($atd, $ClientesCrmModel->getOption('messages', 'add'), $ClientesCrmModel->_db->getTableName());

                            if ($data['criar_atendimento'] == 'S'):
                                $atd['created'] = date('Y-m-d H:i:s');
                                $atd['descricao'] = 'Ligar para oferecer nova coleta. Vai fazer um ano que o certificado ' . $dados['orcamento_id'] . '-' . $dados['sequencial'] . ' foi enviado!';
                                $atd['data'] = $WD->adjustToDb($novaData);
                                $atd['status'] = 'A';
                                $ClientesCrmModel->_db->insert($atd, $ClientesCrmModel->getOption('actions', 'add'), $ClientesCrmModel->_db->getTableName());
                            endif;
                            $this->alerta('sucess', 'E-mail enviado com sucesso!');
                        } catch (Zend_Mail_Exception $e) {
                            $this->alerta('error', $e->getMessage());
                        }

                    else:
                        $this->alerta('error', 'Verifique os dados do cliente!');
                    endif;
                else:
                    $this->alerta('error', 'Preencha todos os dados corretamente!');
                    return false;
                endif;
            endif;
        else:
            $dados['destinatarios'] = $dados['email'];
            $auth = new WS_Auth('erp');
            $usuario = $auth->getIdentity();
            $dados['remetente'] = $usuario->id;
            if (!empty($dados['emaila'])):
                $dados['destinatarios'] .= '; ' . $dados['emaila'];
            endif;

            $this->view->form->populate($dados);
        endif;
    }

    public function visualizarAction() {
        $certificado_id = $this->_getParam('id');
        $certificado = $this->model->find($certificado_id);
        $certificado = $this->model->adjustToView($certificado);
        $this->view->noLogo = true;
        $certificado['numero'] = $certificado['orcamento_id'] . '.' . $certificado['sequencial'];
        $certificado['tratamento'] = $certificado['inicio_tratamento'] . ' - ' . $certificado['fim_tratamento'];

        $this->view->certificado = $certificado;
    }

    public function clienteAction() {
        $cliente_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

}
