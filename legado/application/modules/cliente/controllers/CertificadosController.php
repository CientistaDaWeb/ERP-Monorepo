<?php

class Cliente_CertificadosController extends Cliente_Controller_Action {

    public function indexAction() {
        $CertificadosModel = new Certificados_Model();
        $auth = new WS_Auth('cliente');
        $usuario = $auth->getIdentity();
        $this->view->items = $CertificadosModel->getByCliente($usuario->id);
    }

    public function pesquisaAction() {
        $mostra = true;
        $this->model = new PesquisaSatisfacao_Model();
        $certificado_id = base64_decode($this->_getParam('id'));
        $this->view->certificado_id = $certificado_id;
        $this->form = WS_Form_Generator::generateForm('PesquisaSatisfacao', $this->model->getFormFields());
        $CertificadosModel = new Certificados_Model();

        if ($this->_request->isPost()):
            if ($this->form->isValid($this->_request->getPost())) :
                $data = $this->form->getValues();
                $data['data'] = date('Y-m-d');
                $data['created'] = date('Y-m-d H:i:s');
                $id = $this->model->_db->insert($data);
                $this->alerta('sucess', 'Obrigado por responder nossa pesquisa de satisfacao');
                $mostra = false;
            endif;
        endif;

        $respondeu = $this->model->buscaPorCertificado($certificado_id);
        if ($respondeu):
            $mostra = false;
        endif;
        $item = $CertificadosModel->find($certificado_id);
        $pdf = 'Certificado_' . $item['orcamento_id'] . '_' . $item['id'] . '.pdf';
        $this->view->url = $url = '/storage/file/' . $pdf . '/certificados/save?cache=' . date('U');
        $this->view->mostra = $mostra;
    }

}
