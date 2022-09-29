<?php

class Erp_EmpresasArquivosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new EmpresasArquivos_Model();
        $this->form = WS_Form_Generator::generateForm('EmpresasArquivos', $this->model->getFormFields());
        parent::init();
    }

    public function empresaAction() {
        $empresa_id = $this->_getParam('parent_id');
        $this->view->paren_id = $empresa_id;
        $items = $this->model->buscarPorempresa($empresa_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $empresa_id = $this->_getParam('parent_id');
        if (!empty($empresa_id)):
            $this->model->_params['empresa_id'] = $empresa_id;
        endif;
        parent::formularioAction();
    }

    public function uploadAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $auth = new WS_Auth('erp');
        $dados = array();
        $dados['empresa_id'] = $this->_getParam('empresa_id');
        $dados['created'] = date('Y-m-d H:i:s');
        if ($this->_request->isPost()):
            if (!empty($_FILES)) {
                foreach ($_FILES AS $ARQUIVO) :
                    $upload = new Upload($ARQUIVO);
                    $upload->mime_check = false;
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/empresas-arquivos/');
                        if ($upload->processed) {
                            $dados['arquivo'] = $upload->file_dst_name;
                            $dados['descricao'] = $upload->file_dst_name;
                            $dados['created'] = date('Y-m-d H:i:s');
                            $this->model->_db->insert($dados, $this->model->getOption('messages', 'add'), $this->model->_db->getTableName());
                            $sucesso = true;
                        } else {
                            echo $upload->error;
                        }
                    } else {
                        echo $upload->error;
                    }
                endforeach;
            } else {
                echo 'Nenhum arquivo selecionado!';
            }
            if (isset($sucesso)):
                echo '1';
            endif;
        else:
            echo 'Formul&aacute;rio n&atilde;o enviado corretamente!';
        endif;
        exit();
    }

    public function contadorAction() {
        $empresa_id = $this->_getParam('parent_id');
        if (!empty($empresa_id)):
            $dados['empresa_id'] = $this->model->_params['empresa_id'] = $empresa_id;
        endif;

        $this->form = WS_Form_Generator::generateForm('ArquivosContador', $this->model->formContador());
        $this->form->populate($dados);
        $this->view->form = $this->form;
    }

    public function enviarContadorAction() {
        $form = $this->form = WS_Form_Generator::generateForm('ArquivosContador', $this->model->formContador());
        if ($this->_request->isPost()):
            if ($form->isValid($this->_request->getPost())) :
                $data = $this->_getAllParams();
                if (!empty($_FILES)):
                    foreach ($_FILES AS $ARQUIVO):
                        if (!empty($ARQUIVO['name'])):
                            $upload = new Upload($ARQUIVO);
                            $upload->mime_check = false;
                            if ($upload->uploaded) {
                                $upload->Process(UPLOAD_PATH . '/empresas-arquivos/contador');
                                if ($upload->processed) {
                                    $arquivos[] = $upload->file_dst_pathname;
                                    $sucesso = true;
                                } else {
                                    echo $upload->error;
                                }
                            } else {
                                echo $upload->error;
                            }
                        endif;
                    endforeach;
                    if (!empty($arquivos)):
                        $WSFile = new WS_File();
                        $zipado = $data['nome'] . '-' . date('U') . '.zip';
                        $dados['arquivo'] = $zipado;
                        $dados['descricao'] = $data['descricao'];
                        $dados['categoria_id'] = 6;
                        $dados['empresa_id'] = $data['empresa_id'];
                        $dados['created'] = date('Y-m-d H:i:s');
                        $WSFile->create_zip($arquivos, UPLOAD_PATH . '/empresas-arquivos/' . $zipado, true);
                        $this->model->_db->insert($dados, $this->model->getOption('messages', 'add'), $this->model->_db->getTableName());

                        try {
                            $mail = new Email_Model('UTF-8');
                            $emailConteudo['arquivo'] = $zipado;
                            $emailConteudo['descricao'] = $data['descricao'];

                            $this->view->conteudo = $emailConteudo;
                            $body = $this->view->render('emails/contador.phtml');

                            $mail->setBodyHtml($body, 'utf-8');
                            $mail->setSubject('Arquivos Acquasana ' . date('d/m/Y'));
//                            $mail->addTo('fernando@webscientist.com.br');
                            $mail->addTo('fiscal@cavallicontabil.com.br');
                            $mail->addTo('fiscal1@cavallicontabil.com.br');

                            $mail->addBcc('acquasana@acquasana.com.br');
                            $mail->setReplyTo('acquasana@acquasana.com.br');

                            $arquivo = UPLOAD_PATH . '/empresas-arquivos/' . $zipado;
                            if (is_file($arquivo)) :
                                $at = new Zend_Mime_Part(file_get_contents($arquivo));
                                $at->type = 'application/zip';
                                $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                                $at->encoding = Zend_Mime::ENCODING_BASE64;
                                $at->filename = $zipado;
                                $mail->addAttachment($at);

                                $mail->envia('acquasana@acquasana.com.br', 'Acquasana');
//                                $this->alerta('sucess', 'E-mail enviado com sucesso para o contador!');
                                echo 'E-mail enviado com sucesso para o contador!';
                            endif;
                        } catch (Zend_Mail_Exception $e) {
//                            $this->alerta('error', $e->getMessage());
                            echo $e->getMessage();
                        }
                    else:
//                        $this->alerta('error', 'Nenhum arquivo enviado!');
                        echo 'Nenhum arquivo enviado!';
                    endif;
                else:
//                    $this->alerta('error', 'Nenhum arquivo enviado!');
                    echo 'Nenhum arquivo enviado!';
                endif;
            else:
                $this->alerta('error', 'Formulário não enviado corretamente!');
                echo 'Formulário não enviado corretamente!';
            endif;
        endif;
        exit();
    }

}
