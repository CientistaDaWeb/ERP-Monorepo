<?php

class Erp_BaterPontoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Pontos_Model();
        //$this->form = WS_Form_Generator::generateForm('Pontos', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        $dados = NULL;
        $this->model->setFormIdentifyUser();
        $this->form = WS_Form_Generator::generateForm('BaterPonto', $this->model->getFormFields());
        $UsuariosModel = new Usuarios_Model();
        if ($this->_request->isPost()) :
            $data = $this->_request->getPost();

            if ($this->form->isValid($this->_request->getPost())) :
                $usuario = $UsuariosModel->findByToken($data['token']);
                if (!empty($usuario)):
                    $date = Zend_Date::now();
                    $data2 = $date->getTimestamp();
                    $codigo = base64_encode($data2 . '-' . $data['token']);
                    $this->_redirect('/erp/bater-ponto/confirmacao/' . $codigo);
                else:
                    $this->_helper->FlashMessenger(array('error' => 'Usuário não encontrado!'));
                endif;
            else :
                $this->_helper->FlashMessenger(array('error' => 'Preencha todos os campos obrigatórios!'));
                $this->form->populate($this->_request->getPost())->markAsError();
            endif;
        endif;

        $dados['usuarios'] = $UsuariosModel->fetchPairPonto();

        $this->view->dados = $dados;
        $this->view->form = $this->form;
    }

    public function confirmacaoAction() {
        $this->model->setFormBaterPonto();
        $this->form = WS_Form_Generator::generateForm('BaterPonto', $this->model->getFormFields());
        $UsuariosModel = new Usuarios_Model();

        $data = $this->_getAllParams();

        $codigo = base64_decode($data['id']);
        $dados = explode('-', $codigo);
        $timestamp = $dados[0];
        $token = $dados[1];
        $usuario = $UsuariosModel->findByToken($token);
        $dados['usuario'] = $usuario;

        $dados['data'] = new Zend_Date($timestamp);

        if (!empty($usuario['nome'])):
            $ponto = $this->model->getLastPoint($usuario['id']);
            if (empty($ponto)):
                $dados['tipo'] = 'Entrada';
            else:
                $dados['tipo'] = 'Saída';
            endif;

            if ((!empty($data['acao'])) && ($data['acao'] == 'confirmar')):
                $agora = new Zend_Date();
                $horaponto = new Zend_Date($timestamp);
                $horaponto->addMinute(1);

                $hora = date('H:i:s', $timestamp);

                if ($agora->compare($horaponto) == -1):
                    if (!empty($ponto['id'])):
                        $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $ponto['id']);
                        $ponto = null;
                        $ponto['hora_final'] = $hora;
                        $this->model->_db->update($ponto, $where);
                    else:
                        $ponto['created'] = date('Y-m-d H:i:s');
                        $ponto['hora_inicial'] = $hora;
                        $ponto['data'] = date('Y-m-d', $timestamp);
                        $ponto['usuario_id'] = $usuario['id'];
                        $this->model->_db->insert($ponto);
                    endif;
                    $this->_helper->FlashMessenger(array('sucess' => $dados['tipo'] . ' cadastrada com sucesso!'));
                else:
                    $this->_helper->FlashMessenger(array('error' => 'Expirou o tempo para bater o ponto!'));
                endif;

                $this->_redirect('/erp/bater-ponto');
            else:
                $formulario['id'] = $data['id'];
                $this->form->populate($formulario);
            endif;
        else:
            $this->_helper->FlashMessenger(array('error' => 'Usuário não encontrado!'));
        endif;

        $this->view->dados = $dados;
        $this->view->form = $this->form;
    }

}

