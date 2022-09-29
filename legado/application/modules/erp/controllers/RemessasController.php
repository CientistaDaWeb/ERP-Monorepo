<?php

class Erp_RemessasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Remessas_Model();
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        if ($this->_request->isPost()):
            $faturas = $this->_getParam('conta');
            $forma_pagamento_id = $this->_getParam('forma_pagamento_id');
            $Cnab = new CnabItau_Model();
            $id = $Cnab->criaArquivo($faturas, $forma_pagamento_id);
            $this->_redirect('/erp/Remessas/formulario/' . $id);
        else :
            $id = $this->_getParam('id');
            if (!empty($id)):
                $ContasReceberModel = new ContasReceber_Model();
                $contas = $ContasReceberModel->buscarPorRemessa($id);
                $this->view->contas = $contas;

                $item = $this->model->find($id);
                $this->view->item = $item;
            endif;
        endif;
    }

    public function salvaarquivoAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);

        $arquivo = file_get_contents(UPLOAD_PATH . 'remessas/' . $item['arquivo']);

        $this->getResponse()
                ->setHeader('Content-Disposition', 'attachment; filename=' . $item['arquivo'])
                ->setHeader('Content-type', 'text/plain')
                ->setBody($arquivo);
    }

    public function buscacontasAction() {
        $forma_pagamento_id = $this->_getParam('parent_id');
        $ContasReceberModel = new ContasReceber_Model();
        $contas = $ContasReceberModel->buscarSemRemessa($forma_pagamento_id);
        if (!empty($contas)):
            echo '<form id="RemessaForm" method="POST">
                <input type="hidden" id="forma_pagamento_id" name="forma_pagamento_id" value="' . $forma_pagamento_id . '">
                <table class="listagem">
                <thead>
                    <tr>
                        <th></th>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($contas AS $conta):
                $conta = $ContasReceberModel->adjustToView($conta);
                echo '<tr>
                    <td><input type="checkbox" value="' . $conta['id'] . '" name="conta[]" /></td>
                    <td>' . $conta['cliente'] . '</td>
                    <td>' . $conta['valor']. '</td>
                    <td>' . $conta['data_vencimento'] . '</td>
</tr>';
            endforeach;
            echo '</tbody></table>
                <button type="submit" class="margemT">Gerar Remessa</button>
</form>';
        else:
            echo '<div class="error">Nenhuma conta encontrada!</div>';
        endif;
    }

}