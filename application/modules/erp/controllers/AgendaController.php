<?php

class Erp_AgendaController extends Erp_Controller_Action {

    public function init() {
        $this->model = new UsuariosCompromissos_Model();
        $this->form = new UsuariosCompromissos_Form();
        parent::init();
    }

    public function indexAction() {

    }

    public function vielAction() {

    }

    public function eventosvielAction() {
        $this->model->_params['usuario_id'] = 6;
        $data = $this->_getAllParams();
        $dataInicio = new Zend_Date($data['start']);
        $inicio = $dataInicio->toString('yyyy-MM-dd');
        $dataFim = new Zend_Date($data['end']);
        $fim = $dataFim->toString('yyyy-MM-dd');

        $items = $this->model->agenda($inicio, $fim, $this->model->_params['usuario_id']);

        if (!empty($items)):
            foreach ($items AS $item):
                $evento['id'] = $item['id'];
                $evento['title'] = '(' . $item['dono'] . ') ' . $item['titulo'] . ' - ' . $item['descricao'];
                $evento['start'] = $item['data'] . ' ' . $item['hora'];
                $evento['end'] = $item['data'] . ' ' . $item['hora'];
                $evento['allDay'] = false;
                if ($item['status'] == 'C'):
                    $evento['color'] = '#899B30';
                else:
                    $evento['color'] = '#BB9A00';
                endif;
                $eventos[] = $evento;
            endforeach;
            $ZJ = new Zend_Json();
            print_r($ZJ->encode($eventos));
        endif;
        exit();
    }

    public function eventosAction() {
        $data = $this->_getAllParams();
        $dataInicio = new Zend_Date($data['start']);
        $inicio = $dataInicio->toString('yyyy-MM-dd');
        $dataFim = new Zend_Date($data['end']);
        $fim = $dataFim->toString('yyyy-MM-dd');

        $items = $this->model->agenda($inicio, $fim, $this->model->_params['usuario_id']);

        if (!empty($items)):
            foreach ($items AS $item):
                $evento['id'] = $item['id'];
                $evento['title'] = ' ' . $item['nome'] . ' - ' . $item['titulo'] . ' - ' . $item['cliente'] . ' - ' . $item['local'];
                $evento['start'] = $item['data'] . ' ' . $item['hora'];
                $evento['end'] = $item['data'] . ' ' . $item['hora'];
                $evento['allDay'] = false;
                if ($item['status'] == 'C'):
                    $evento['color'] = '#899B30';
                else:
                    $evento['color'] = '#BB9A00';
                endif;
                $eventos[] = $evento;
            endforeach;
            $ZJ = new Zend_Json();
            print_r($ZJ->encode($eventos));
        endif;

        exit();
    }

    public function formularioAction() {
        $auth = new WS_Auth('erp');
        $usuario = $auth->getIdentity();
        if (!$this->_hasParam('usuario_id') && !isset($this->model->_params['usuario_id'])):
            $this->model->_params['usuario_id'] = $usuario->id;
        endif;

        if ($this->_hasParam('viel')):
            $this->model->_params['usuario_id'] = 6;
        endif;

        $dados = $this->_getAllParams();
        $data = $this->_request->getPost();
        if ($this->_request->isPost()):
            if (empty($data['id'])):
                if ($this->form->isValid($this->_request->getPost())) :
                    $data = $this->_request->getPost();
                    $data = $this->model->adjustToDb($data);
                    unset($data['repeticao']);
                    unset($data['periodicidade']);
                    unset($data['cancelar']);
                    unset($data['salvar']);
                    if (empty($data['cliente_id'])):
                        unset($data['cliente_id']);
                    endif;

                    try {
                        $WD = new WS_Date($data['data']);
                        for ($i = 0; $i < $dados['repeticao']; $i++):
                            if ($i != 0):
                                $WD->add($dados['periodicidade'], Zend_Date::DAY);
                                $data['data'] = $WD->toString('yyyy-MM-dd');
                            endif;

                            $id = $this->model->_db->insere($data, $this->model->getOption('actions', 'add'), $this->model->_db->getTableName());

                            if ($data['usuario_id'] == 6):
                                $UsuariosModel = new Usuarios_Model();
                                $usuario = $UsuariosModel->find($data['usuario_id']);
                                $mail = new Email_Model('utf-8');

                                $this->view->conteudo = $this->model->adjustToView($data);
                                $body = $this->view->render('emails/agenda.phtml');

                                $mail->setBodyHtml($body, 'utf-8');
                                $mail->setSubject('Novo compromisso inserido! - ' . $data['titulo']);
                                $mail->setReplyTo('acquasana@acquasana.com.br');
                                $mail->addTo($usuario['email'], $usuario['nome']);
//                                $mail->addTo('fernando@webscientist.com.br');
                                $mail->envia('acquasana@acquasana.com.br', 'Acquasana');
                            endif;

                            $ClientesCrmModel = new ClientesCrm_Model();
                            $dados = '';
                            $dados['created'] = date('Y-m-d H:i:s');
                            $dados['cliente_id'] = $data['cliente_id'];
                            $dados['usuario_id'] = $data['usuario_id'];
                            $dados['data'] = date('Y-m-d');
                            $dados['descricao'] = 'Inseriu um novo compromisso - ' . $data['titulo'] . ' (' . $WD->toString('dd/MM/yyyy') . ')';
                            $ClientesCrmModel->_db->insere($dados, $ClientesCrmModel->getOption('actions', 'add'), $ClientesCrmModel->_db->getTableName());

                        endfor;
                        if (!isset($this->options['noRedirect'])):
                            $this->_helper->FlashMessenger(array('sucess' => $this->model->getOption('messages', 'add')));
                        else:
                            $this->alerta('sucess', $this->model->getOption('messages', 'add'));
                        endif;
                        if ($this->_getParam('submodulo')):
                            echo '<script>
                            $(".modal").dialog("close");
                            </script>';
                            exit();
                        else:
                            $this->_redirect('/' . $this->module . '/Agenda');
                        endif;
                    } catch (Error $e) {
                        if (!isset($this->options['noRedirect'])):
                            $this->_helper->FlashMessenger(array('error' => $e->getMessage()));
                        else:
                            $this->alerta('error', $e->getMessage());
                        endif;
                        $data = $this->model->adjustToForm($data);
                        $this->form->populate($data)->markAsError();
                        parent::formularioAction();
                    }
                else:
                    parent::formularioAction();
                endif;
            else:
                parent::formularioAction();
            endif;
        else:
            if (!empty($dados['id'])):
                $evento = $this->model->find($dados['id']);
                if ($evento['cliente_id']):
                    echo '<div class="clear margemB"></div>';
                    echo '<a class="botao" href="/erp/Clientes/formulario/' . $evento['cliente_id'] . '#ui-tabs-3" target="_blank">Ir para o Cliente</a>';
                endif;
            endif;
            parent::formularioAction();
        endif;
    }

    public function converterAction() {
        if ($this->_hasParam('atendimento_id')):
            $id = $this->_getParam('atendimento_id');
            $ClientesCrmModel = new ClientesCrm_Model();
            $atendimento = $ClientesCrmModel->find($id);
            $this->model->_params['usuario_id'] = $atendimento['usuario_id'];
            $this->model->_params['cliente_id'] = $atendimento['cliente_id'];
            $this->model->_params['descricao'] = $atendimento['descricao'];
            $this->model->_params['data'] = WS_Date::adjustToView($atendimento['data']);

            self::formularioAction();
        endif;
    }

}
