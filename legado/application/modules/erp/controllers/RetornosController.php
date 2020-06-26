<?php

class Erp_RetornosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Retornos_Model();
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        if ($this->_request->isPost()):
            $data = $this->_getAllParams();
            if ($_FILES['arquivo']['size'] > 0):
                $upload = new Upload($_FILES['arquivo']);
                $upload->mime_check = false;
                $caminho = UPLOAD_PATH . 'retornos/';
                $upload->process($caminho);
                if ($upload->processed):
                    $Cnab = new CnabItau_Model();
                    $id = $Cnab->leRetorno($upload->file_dst_name, $caminho);
                    $this->_redirect('/' . $this->module . '/' . $this->controller . '/formulario/' . $id);
                else:
                    $this->alerta('error', 'Erro ao fazer o upload do arquivo! ' . $upload->error);
                endif;
            else:
                $this->alerta('error', 'Preencha o campo do arquivo!');
            endif;
        else:
            $id = $this->_getParam('id');
            if (!empty($id)):
                $ContasReceberModel = new ContasReceber_Model();
                $contas = $ContasReceberModel->buscarPorRetorno($id);
                $this->view->contas = $contas;

                $item = $this->model->find($id);
                $this->view->item = $item;
            endif;
        endif;
    }

    public function salvaarquivoAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);

        $arquivo = file_get_contents(UPLOAD_PATH . 'retornos/' . $item['arquivo']);

        $this->getResponse()
                ->setHeader('Content-Disposition', 'attachment; filename=' . $item['arquivo'])
                ->setHeader('Content-type', 'text/plain')
                ->setBody($arquivo);
    }

}
