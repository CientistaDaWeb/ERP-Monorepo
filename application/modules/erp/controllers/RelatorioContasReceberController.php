<?php

class Erp_RelatorioContasReceberController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ContasReceber_Model();
        parent::init();
        $this->model->_title = 'Relatório de ' . $this->model->getOption('plural');
    }

    public function indexAction() {
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
        $data['data_final'] = date('d/m/Y');
        $data['data_inicial_pago'] = '';
        $data['data_final_pago'] = '';
        $data['data_inicial_lancamento'] = '';
        $data['data_final_lancamento'] = '';
        $data['status'] = '';
        $data['cliente_id'] = '';
        $data['empresa_id'] = '';
        $data['forma_pagamento_id'] = '';
        $data['ordem'] = '';
        $data['ordem_tipo'] = '';
        $data['gera_csv'] = '';

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            /* Limita a data final da pesquisa quando não for administrador */
            $auth = new WS_Auth('erp');
            $user = $auth->getIdentity();
            if ($user->papel != 'A'):
                /* Limita a data inicial */
//                $data = Erp_Date::dateLimit($data, 35, 'data_inicial');
            endif;

            $items = $this->model->Relatorio($data);

            if ($data['gera_csv']):
                $linhas = array();
                $total_pago = 0;
                $total_gerado = 0;
                $linhas[] = 'Status;Data de lançamento;Data de Vencimento;Valor;Orcamento;Cliente;Data de Pagamento;Valor Pago;Fornecedor;Cat. Conta;Empresa;Forma Pag.;CT-e';
                foreach ($items AS $item):
                    $retorno = array();
                    $dados = $this->model->adjustToView($item);
                    $retorno['status'] = $dados['status'];
                    $retorno['data_lancamento'] = $dados['data_lancamento'];
                    $retorno['data_vencimento'] = $dados['data_vencimento'];
                    $retorno['valor'] = $dados['valor'];
                    $retorno['orcamento'] = $dados['orcamento_id'];
                    $retorno['cliente'] = $dados['cliente'];
                    $retorno['data_pagamento'] = $dados['data_pagamento'];
                    $retorno['valor_pago'] = $dados['valor_pago'];
                    $retorno['fornecedor'] = $dados['fornecedor'];
                    $retorno['categoria'] = $dados['categoria'];
                    $retorno['empresa'] = $dados['empresa'];
                    $retorno['forma_pagamento'] = $dados['forma_pagamento'];
                    $retorno['cte'] = $dados['cte_id'];
                    $linhas[] = implode(';', $retorno);
                    $total_pago += $item['valor_pago'];
                    $total_gerado += $item['valor'];
                endforeach;
                $linhas[] = ';;Total Gerado;' . WS_Money::adjustToView($total_gerado) . ';;;Total Pago;' . WS_Money::adjustToView($total_pago) . ';;;;;';

                $WF = new WS_File();
                $file = 'contas_receber'.date('U').'.csv';
                $arquivo = UPLOAD_PATH . '/' . $file;
                $WF->remove($arquivo);
                $WF->create($arquivo, $linhas);
                $this->view->csv = $file;
            endif;
            $this->view->items = $items;
        endif;
        $this->view->data = $data;
    }

    /*
      public function gerararquivoAction() {
      $this->_helper->layout->disableLayout();
      $this->_helper->viewRenderer->setNoRender();

      if ($this->_request->isPost()):
      $data = $this->_getAllParams();
      $items = $this->model->Relatorio($data);

      $valorTotal = 0;
      $valorRecebido = 0;
      $WD = new WS_Date();
      $WM = new WS_Money();

      foreach ($items AS $item):
      $ZD = new Zend_Date($item['data_vencimento']);
      $hoje = $WD->hoje();
      $Vencimento = new WS_Date($item['data_vencimento']);
      if (!empty($item['valor_pago'])):
      $status['status'] = 'Pago';
      elseif ($Vencimento->compare($WD->hoje()) == 1):
      $status['status'] = 'Em Aberto';
      else:
      $status['status'] = 'Atrasada';
      endif;
      $valorTotal+=$item['valor'];
      $valorRecebido+=$item['valor_pago'];

      $os['item_status'] = $status['status'];
      $os['item_data'] = $WD->ajustaSite($item['data_vencimento']);
      $os['item_valor'] = $WM->ajustaSite($item['valor']);
      $os['item_orcamento'] = $item['orcamento_id'];
      $os['item_cliente'] = $item['razao_social'];
      if ($status['status'] == 'Pago'):
      $os['item_pagamento'] = $WD->ajustaSite($item['data_pago']) . ' -  ' . $WM->ajustasite($item['valor_pago']);
      endif;
      $contas[] = $os;
      endforeach;

      $application = Zend_Registry::get('application');
      try {
      $phpLiveDocx = new Zend_Service_LiveDocx_MailMerge();
      $phpLiveDocx->setUsername($application->service->livedocx->username)
      ->setPassword($application->service->livedocx->password);

      $phpLiveDocx->setRemoteTemplate('RelatorioContasReceber.docx');
      $phpLiveDocx
      ->assign('data_inicial', $WD->ajustaSite($data['data_inicial']))
      ->assign('data_final', $WD->ajustaSite($data['data_final']))
      ->assign('total', count($contas))
      ->assign('item', $contas)
      ->assign('total_gerado', $valorTotal)
      ->assign('total_recebido', $valorRecebido)
      ;
      $phpLiveDocx->createDocument();

      $document = $phpLiveDocx->retrieveDocument('pdf');
      echo serialize($document);
      } catch (Zend_Service_LiveDocx_Exception $e) {
      echo $e->getMessage();
      }

      $this->getResponse()
      ->setHeader('Content-Disposition', 'attachment; filename=Relatorio-de-Contas-a-Receber')
      ->setHeader('Content-type', 'application/x-pdf')
      ->setBody($document);
      endif;
      }
     *
     */
}
