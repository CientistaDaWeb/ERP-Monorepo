<?php

class Erp_Controller_Action extends WS_Controller_Action {

    public function init() {
        parent::init();

        if (!isset($this->noLogin)):
            $auth = new WS_Auth('erp');
            if (($this->_request->getControllerName() != 'Auth') && ($this->_request->getControllerName() != 'bater-ponto')):
                if ($auth->hasIdentity()) :
                    $this->view->User = $auth->getIdentity();
                else:
                    $this->_redirect('/erp/Auth');
                endif;

                $data = $this->_request->getParams();
                if ($auth->hasIdentity()):
                    $acl = new AclAcessos_Model();
                    $usuario = $auth->getIdentity();
                    if ($usuario->papel):
                        $role = $usuario->papel;
                    else:
                        $role = 'V';
                    endif;
                    if (!$acl->isAllowed($role, 'erp:' . $this->_request->getControllerName())):
                        $this->_redirect($this->module . '/Permissao-Negada//' . $this->_request->getControllerName());
                    endif;
                else:
                    $this->_redirect('/' . $this->module);
                endif;
            endif;
        endif;
    }

    public function mpdfAction() {
        date_default_timezone_set('America/Sao_Paulo');
        $data = $this->_getAllParams();
        $this->view->gerandoPdf = true;

        $html = file_get_contents($data['url'].'?gerandoPDF=true');

        $path = realpath('../library/mPDF/');
        require_once $path . '/mpdf.php';

        $mpdf = new mPDF();
        $mpdf->debug = false;
        $mpdf->simpleTables = true;
        $mpdf->SetAutoFont();
        $mpdf->WriteHTML($html);

        $documento = UPLOAD_PATH . $data['pasta'] . $data['arquivo'];
        unlink($documento);
        if (!$mpdf->Output($documento, 'F')):
            $this->alerta('sucess', 'PDF Gerado com sucesso.');
        else:
            $this->alerta('error', 'Erro ao gerar o PDF!<br />');
        endif;
        exit();
    }

}
