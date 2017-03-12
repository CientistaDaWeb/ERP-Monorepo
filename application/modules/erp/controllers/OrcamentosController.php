<?php

class Erp_OrcamentosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Orcamentos_Model();
        $this->form = WS_Form_Generator::generateForm('Orcamentos', $this->model->getFormFields());

        if ($this->_request->getActionName() == 'ver'):
            $this->noLogin = true;
        endif;
        parent::init();
    }

    public function formularioAction() {
        $auth = new WS_Auth('erp');
        $usuario = $auth->getIdentity();

        $cliente_id = $this->_getParam('parent_id');

        if (!empty($cliente_id)):
            $this->model->_params['cliente_id'] = $this->_getParam('parent_id');
        endif;

        $this->options['noList'] = true;
        if (!$this->_hasParam('usuario_id')):
            $this->model->_params['usuario_id'] = $usuario->id;
        endif;

        parent::formularioAction();
    }

    public function visualizarAction() {
        $id = $this->_getParam('parent_id');
        $data['orcamento_id'] = $id;
        $this->view->id = $id;

        $arquivo = UPLOAD_PATH . 'orcamentos/Orcamento_' . $id . '.pdf';
        if (is_file($arquivo)):
            $dados = stat($arquivo);
            $this->view->pdf_gerado = $dados[9];
            $this->view->pdf = 'Orcamento_' . $id . '.pdf';
        endif;
    }

    public function enviaremailAction() {
        $dados = $this->model->buscaCliente($this->_getParam('parent_id'));
        $form = new Orcamentos_FormEmail();
        if ($this->_request->isPost()):
            if ($form->isValid($this->_request->getPost())) :
                try {
                    $data = $this->_getAllParams();

                    $mail = new Email_Model('utf-8');

                    $this->view->conteudo = $data;
                    $body = $this->view->render('emails/orcamento.phtml');

                    $mail->setBodyHtml($body, 'utf-8');
                    $mail->setSubject(utf8_decode($data['assunto']) . ' (' . $data['parent_id'] . ')');
                    $mail->setReplyTo('acquasana@acquasana.com.br');

                    $destinatarios = explode(';', $data['destinatarios']);
                    foreach ($destinatarios AS $destinatario):
                        $mail->addTo($destinatario);
                    endforeach;
                    $mail->addBcc('acquasana@acquasana.com.br');

                    $arquivo = realpath(UPLOAD_PATH . 'orcamentos/Orcamento_' . $data['parent_id'] . '.pdf');

                    $at = new Zend_Mime_Part(file_get_contents($arquivo));
                    $at->type = 'application/pdf';
                    $at->disposition = Zend_Mime::DISPOSITION_INLINE;
                    $at->encoding = Zend_Mime::ENCODING_BASE64;
                    $at->filename = $data['parent_id'] . '.pdf';

                    $mail->addAttachment($at);
//                    $mail->addAttachment(file_get_contents($arquivo), 'application/pdf', Zend_Mime::DISPOSITION_INLINE, Zend_Mime::ENCODING_BASE64);
                    $mail->envia('acquasana@acquasana.com.br', 'Acquasana');

                    $auth = new WS_Auth('erp');
                    $usuario = $auth->getIdentity();

                    $atendimento = new ClientesCrm_Model();
                    $atd['cliente_id'] = $dados['cliente_id'];
                    $atd['usuario_id'] = $usuario->id;
                    $atd['created'] = date('Y-m-d H:i:s');
                    $atd['data'] = date('Y-m-d');
                    $atd['descricao'] = 'Enviou o Orçamento por e-mail.';
                    $atd['status'] = 'R';

                    $atendimento->_db->insert($atd);

                    $this->alerta('sucess', 'E-mail enviado com sucesso!');
                } catch (Zend_Mail_Exception $e) {
                    $this->alerta('error', $e->getMessage());
                }
            else:
                $this->alerta('error', 'Preencha todos os dados corretamente!');
                return false;
            endif;
        else:
            $dados['destinatarios'] = $dados['email'];
            $form->populate($dados);
            $this->view->form = $form;
        endif;
    }

    public function configuracaoAction() {
        $this->form = new Orcamentos_FormConfiguracao();
        $parent_id = $this->_getParam('parent_id');
        if (!empty($parent_id)):
            $this->model->_params['id'] = $parent_id;
            $dados = $this->model->find($parent_id);
            $this->form->populate($dados);
        endif;



        parent::formularioAction();
    }

    public function verAction() {
        $this->view->noLogo = true;
        $orcamento_id = $this->_getParam('id');
        $orcamento = $this->model->find($orcamento_id);
        $this->view->orcamento = $orcamento;

        $ServicosModel = new Servicos_Model();
        $servicosOrcamento = $ServicosModel->buscarPorOrcamento($orcamento_id);
        $this->view->servicos = $servicosOrcamento;
    }

    public function clienteAction() {
        $cliente_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

    public function gerarpdfAction() {
        $orcamento_id = $this->_getParam('id');
        $timbrado = $this->_getParam('timbrado');

        if (!$timbrado):
            $document = $this->model->gerarPdf($orcamento_id);
        else:
            $document = $this->model->gerarPdf($orcamento_id, $timbrado);
            $arquivo = 'Orcamento_' . $orcamento_id . '.pdf';
            $this->getResponse()
                    ->setHeader('Content-Disposition', 'attachment; filename=' . $arquivo)
                    ->setHeader('Content-type', 'application/x-pdf')
                    ->setBody($document);
        endif;
    }

    public function verpdfAction() {
        $id = $this->_getParam('id');
        $arquivo = 'Orcamento_' . $id . '.pdf';
        $document = file_get_contents(UPLOAD_PATH . 'orcamentos/' . $arquivo);
        $this->getResponse()
                ->setHeader('Content-Disposition', 'attachment; filename=' . $arquivo)
                ->setHeader('Content-type', 'application/x-pdf')
                ->setBody($document);
    }

    public function gerarnovopdfAction() {
        date_default_timezone_set('America/Sao_Paulo');
        $orcamento_id = $this->_getParam('id');

        $configs = Zend_Registry::get('application');
        $dominio = $configs->cliente->dominio;
        $html = file_get_contents('http://' . $dominio . '/erp/print/Orcamentos/ver/' . $orcamento_id);

        $path = realpath('../library/mPDF/');
        require_once $path . '/mpdf.php';

        $mpdf = new mPDF();
        $mpdf->debug = false;
        $mpdf->simpleTables = true;
        $mpdf->WriteHTML($html);
        $arquivo = 'Orcamento_' . $orcamento_id . '.pdf';
        $documento = UPLOAD_PATH . 'orcamentos/' . $arquivo;
        unlink($documento);
        if (!$mpdf->Output($documento, 'F')):
            $this->alerta('sucess', 'PDF Gerado com sucesso.');
        else:
            $this->alerta('error', 'Erro ao gerar o PDF!<br />');
        endif;
        exit();
    }

}
