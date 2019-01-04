<?php

class Erp_CteAcquaservicosController extends Erp_Controller_Action
{

  public function init()
  {
    $this->model = new CtesAcquaservicos_Model();
    $this->form = WS_Form_Generator::generateForm('Ctes', $this->model->getFormFields());
    require_once('NfephpAcquaservicos/libs/CTeNFePHP.class.php');
    $cte = new CTeNFePHP();
    parent::init();
  }

  public function indexAction()
  {
    $this->view->buttons['top'][] = [
      'link' => 'Cte-Acquaservicos/importar-cte',
      'title' => 'Importar CTE',
      'name' => 'importar'
    ];

    parent::indexAction();
  }

  public function clienteAction()
  {
    $cliente_id = $this->_getParam('parent_id');
    $items = $this->model->buscarPorCliente($cliente_id);
    $this->view->items = $items;
  }

  public function dadosAction()
  {
    $cte_id = $this->_getParam('parent_id');
    $item = $this->model->find($cte_id);
    $this->view->item = $item;
  }

  public function formularioAction()
  {
    $this->options['noList'] = true;
    parent::formularioAction();
    /*
      include('NfephpAcquaservicos/libs/ToolsNFePHP.class.php');
      $tools = new ToolsNFePHP();
      $tools->setEmpresa('Acquaservicos');
      Zend_Debug::dump($tools->statusServico('RS', 2, 2));
      exit();
     */
  }

  public function corrigirAction()
  {
    self::formularioAction();
  }

  public function addfaturaAction()
  {
    try {
      $cte_id = $this->_getParam('cte_id');
      $fatura_id = $this->_getParam('fatura_id');
      $ContasReceberModel = new ContasReceber_Model();
      $data['cte_acquaservicos_id'] = $cte_id;
      $where = $ContasReceberModel->_db->getAdapter()->quoteInto('id = ?', $fatura_id);
      $ContasReceberModel->_db->update($data, $where);
      $this->alerta('sucess', 'Conta inserida com sucesso!');

      $data = NULL;
      $data['status'] = 2;
      $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
      $this->model->_db->update($data, $where);
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }

    exit();
  }

  public function cartaAction()
  {
    $cte_id = $this->_getParam('cte_id');
    $alteracoes = $this->_getParam('alteracoes');
    $cte = $this->model->find($cte_id);
    if (!empty($alteracoes)):
      try {
        $campos = $this->model->getOption('campos');
        foreach ($alteracoes AS $id => $item):
          if (!empty($item)):
            if ($id == 'cfop'):
              $CfopModel = new Cfops_Model();
              $cfop = $CfopModel->find($item);

              $dados['grupo'] = $campos[$id]['grupo'];
              $dados['campo'] = $campos[$id]['campo'];
              $dados['valor'] = $cfop['codigo'];
              $eventos[] = $dados;

              $dados['grupo'] = 'ide';
              $dados['campo'] = 'natOp';
              $dados['valor'] = $cfop['descricao'];
              $eventos[] = $dados;
            else:
              $dados['grupo'] = $campos[$id]['grupo'];
              $dados['campo'] = $campos[$id]['campo'];
              $dados['valor'] = $item;
              $eventos[] = $dados;
            endif;
          endif;
        endforeach;

        $nfe = new CTeNFePHP();
//                $nfe->setEmpresa('Acquaservicos');
        $retorno = $nfe->envCCe($cte['codigo'], $eventos, 1);

        if ($nfe->errMsg == '200 OK'):
          $this->alerta('sucess', 'Carta de Correção enviada com sucesso!');
        else:
          $this->alerta('error', 'Falha ao enviar a Carta de Correção! ' . $nfe->errMsg);
        endif;
      } catch (Exception $e) {
        $this->alerta('error', $e->getMessage());
      }
      exit();
    else:
      $this->alerta('error', 'Nenhum campo para alterar!');
    endif;
  }

  public function inutilizarAction()
  {
    $cte_id = $this->_getParam('id');
    $cte = $this->model->find($cte_id);
    $data = new WS_Date($cte['data']);
    try {
      $nfe = new CTeNFePHP();
//            $nfe->setEmpresa('Acquaservicos');
      $retorno = $nfe->inutCT($data->toString('YY'), '1', $cte_id, $cte_id, 'Erro nos dados cadastrados!');
      if ($nfe->errMsg == '200 OK'):
        $data = NULL;
        $data['status'] = 11;
        $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
        $this->model->_db->update($data, $where);

        $data = NULL;
        $data['cte_acquaservicos_id'] = null;
        $ContasReceberModel = new ContasReceber_Model();
        $where = $ContasReceberModel->_db->getAdapter()->quoteInto('cte_acquaservicos_id = ?', $cte_id);
        $ContasReceberModel->_db->update($data, $where);

        $this->alerta('sucess', 'CT-e inutilizada com sucesso!');
      else:
        var_dump($nfe);
        $this->alerta('error', 'Falha ao inutilizar a CT-e!');
      endif;
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }
    exit();
  }

  public function previewAction()
  {
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);
    try {
      $filename = 'uploads/cte/xml/' . $cte['codigo'] . '.xml';
      $xml = file_get_contents($filename);
      require_once('NfephpAcquaservicos/libs/DacteNFePHP.class.php');
      $dacte = new DacteNFePHP($xml, '', '', 'images/logo_dacte.jpg');
      $filename = 'uploads/cte/pdf/' . $cte['codigo'] . '-preview.pdf';
      if ($dacte->montaDACTE()):
        $dacte->printDACTE($filename, 'F');
        $this->alerta('sucess', 'PDF Criado!');
      else:
        $this->alerta('error', 'Falha ao montar o DACTE.');
      endif;
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }
    exit();
  }

  public function removefaturaAction()
  {
    try {
      $fatura_id = $this->_getParam('fatura_id');
      $ContasReceberModel = new ContasReceber_Model();
      $data['cte_acquaservicos_id'] = NULL;
      $where = $ContasReceberModel->_db->getAdapter()->quoteInto('id = ?', $fatura_id);
      $ContasReceberModel->_db->update($data, $where);
      $this->alerta('sucess', 'Conta removida com sucesso!');
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }
    exit();
  }

  public function faturasAction()
  {
    $cte_id = $this->_getParam('parent_id');
    $cte = $this->model->find($cte_id);
    $ContasReceberModel = new ContasReceber_Model();
    $cliente_id = $cte['cliente_id'];
    switch ($cte['toma']):
      case 0:
        $contas_id = $cte['cliente_id'];
        break;
      case 1:
        $contas_id = $cte['expedidor_id'];
        break;
      case 2:
        $contas_id = $cte['recebedor_id'];
        break;
      case 3:
        $contas_id = $cte['destinatario_id'];
        break;
    endswitch;
    $faturasNaoProcessadas = $ContasReceberModel->buscaNaoProcessadasPorCliente($contas_id);
    $items = $ContasReceberModel->buscaPorCteAcquaservicos($cte_id);

    $this->view->items = $items;
    $this->view->cte = $cte;
    $this->view->faturasNaoProcessadas = $faturasNaoProcessadas;
  }

  public function verificaAction()
  {
    include('NfephpAcquaservicos/libs/ToolsNFePHP.class.php');
    $tools = new ToolsNFePHP();
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);
    $filename = 'uploads/cte/xml/' . $cte['codigo'] . '.xml';
    try {
      $tools->verifyNFe($filename);
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }
    exit();
  }

  public function geraxmlAction()
  {
    include('NfephpAcquaservicos/libs/ToolsNFePHP.class.php');
    $tools = new ToolsNFePHP();
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);
    $filename = 'uploads/cte/xml/' . $cte['codigo'] . '.xml';
    try {
      $xml = $this->model->geraXml($cte_id, $filename);
      $assina = $tools->signXML($xml, 'infCte');
      if (!$assina):
        $this->alerta('error', 'Erro ao assinar o xml');
      else:
        $WSF = new WS_File();
        $linhas[] = $assina;
        $WSF->create($filename, $linhas);
        $data['status'] = 3;
        $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
        $this->model->_db->update($data, $where);
        $this->alerta('sucess', 'Xml gerado com sucesso!');
      endif;
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }
    exit();
  }

  public function validarAction()
  {
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);
    require_once('NfephpAcquaservicos/libs/ToolsNFePHP.class.php');
    $nfe = new ToolsNFePHP();
    $filename = 'uploads/cte/xml/' . $cte['codigo'] . '.xml';
    $xsd = realpath('../library/NfephpAcquaservicos/schemes/PL_CTe_300/cte_v3.00.xsd');
    if (!$nfe->validXML($filename, $xsd, $error)):
      foreach ($error AS $e):
        $this->alerta('error', $e);
      endforeach;
    else:
      $data['status'] = 4;
      $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
      $this->model->_db->update($data, $where);
      $this->alerta('sucess', 'Xml validado com sucesso!');
    endif;
    exit();
  }

  public function transmitirAction()
  {
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);
    try {
      $nfe = new CTeNFePHP();
      $filename = 'uploads/cte/xml/' . $cte['codigo'] . '.xml';
      if (empty($cte['lote'])):
        $lote = substr(str_replace(array(',', '.'), array('', ''), number_format(microtime(true) * 1000000, 0)), 0, 15);
        $aCTe = array(0 => file_get_contents($filename));
        if ($aResp = $nfe->sendLot($aCTe, $lote)):
          if (!$aResp['bStat']) :
            $this->alerta('error', 'Houve erro !! (' . $aResp['cStat'] . ') - ' . $aResp['xMotivo']);
          else:
            $data['protocolo'] = $aResp['nRec'];
            $data['lote'] = $lote;
            $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
            $this->model->_db->update($data, $where);
            $this->alerta('sucess', 'Arquivo Transmitido com sucesso!');
          endif;
        else:
          $this->alerta('error', "Houve erro !!  $nfe->errMsg");
        endif;
      endif;
      $configs = Zend_Registry::get('application');
      $ambiente = $configs->cte->ambiente->codigo;
      $ambiente_nome = $configs->cte->ambiente->nome;
      $protocol = $nfe->getProtocol($cte['protocolo'], NULL, $ambiente, 2);
      if ($protocol['aProt'][0]['nProt']):
        $this->alerta('sucess', 'Protocolo Recebido com sucesso!');
        $data = null;
        $data['protocolo_sefaz'] = $protocol['aProt'][0]['nProt'];
        $protocol_file = 'uploads/cte/' . $ambiente_nome . '/temporarias/' . $cte['codigo'] . '-prot.xml';
        $xml = $nfe->addProt($filename, $protocol_file);
        if (!empty($xml)):
          $filename = 'uploads/cte/xml/' . $cte['codigo'] . '-proc.xml';
          $WSF = new WS_File();
          $linhas[] = $xml;
          $WSF->create($filename, $linhas);
          if (is_file($filename)):
            $data['status'] = 5;
            $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
            $this->model->_db->update($data, $where);
            $this->alerta('sucess', 'Protocolo Inserido no XML com sucesso!');
          else:
            $this->alerta('error', "Falha ao criar o arquivo XML processado!");
          endif;
        else:
          $this->alerta('error', "Falha ao inserir o protocolo do Sefaz no XML:" . $nfe->errMsg);
        endif;
      else:
        $this->alerta('error', 'Erro ao receber o protocolo do Sefaz: (' . $protocol['cStat'] . ') ' . $protocol['xMotivo'] . ' / ' . $protocol['aProt'][0]['xMotivo']);
      endif;
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }
    exit();
  }

  public function gerararquivosAction()
  {
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);
    try {
      $filename = 'uploads/cte/xml/' . $cte['codigo'] . '-proc.xml';
      $xml = file_get_contents($filename);
      require_once('NfephpAcquaservicos/libs/DacteNFePHP.class.php');
      $dacte = new DacteNFePHP($xml, '', '', 'images/logo_dacte.jpg');
      $filename = 'uploads/cte/pdf/' . $cte['codigo'] . '.pdf';
      if ($dacte->montaDACTE()):
        if ($dacte->printDACTE($filename, 'F')):
        else:
//$this->alerta('error', 'Falha ao criar o PDF.');
        endif;
      else:
        $this->alerta('error', 'Falha ao montar o DACTE.');
      endif;

      $data['status'] = 6;
      $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
      $this->model->_db->update($data, $where);
      $this->alerta('sucess', 'Arquivos Gerados com sucesso!');
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }
    exit();
  }

  public function enviararquivosAction()
  {
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);

    $arquivo = 'uploads/cte/xml/' . $cte['codigo'] . '.xml';
    $filename = realpath($arquivo);
    if (is_file($filename)) {
      $this->view->xml = $arquivo;
    }

    $arquivo = 'uploads/cte/pdf/' . $cte['codigo'] . '.pdf';
    $filename = realpath($arquivo);
    if (is_file($filename)) {
      $this->view->pdf = $arquivo;
    }

    exit();
  }

  public function arquivosAction()
  {
    $cte_id = $this->_getParam('parent_id');
    $cte = $this->model->find($cte_id);
    $arquivo = 'uploads/cte/xml/' . $cte['codigo'] . '-proc.xml';
    $filename = realpath($arquivo);
    if (is_file($filename)) {
      $this->view->xml = $arquivo;
    }

    $OrdensServicoModel = new OrdensServico_Model();
    $ordenservico = $OrdensServicoModel->getByCteAcquaservicos($cte_id);

    if (!empty($ordenservico)):
      $arquivosOs = array();

      foreach ($ordenservico AS $ordem):
        $ordem['file'] = 'Relatorio_' . $ordem['id'] . '.pdf';
        $arquivo = 'uploads/ordem-servico/' . $ordem['file'];
        $ordem['arquivo'] = $arquivo;
        $filename = realpath($arquivo);
        if (is_file($filename)) :
          $ordem['existe'] = 'S';
        endif;
        $arquivosOs[] = $ordem;
      endforeach;

      $this->view->arquivosOs = $arquivosOs;
    endif;

    $arquivo = 'uploads/cte/xml/' . $cte['codigo'] . '.xml';
    $filename = realpath($arquivo);
    if (is_file($filename)) {
      $this->view->xmlpreview = $arquivo;
    }

    $arquivo = 'uploads/cte/Faturas_Acquaservicos_' . $cte_id . '.pdf';
    $filename = realpath($arquivo);
    if (is_file($filename)) {
      $this->view->faturas = $arquivo;
    }

    $arquivo = 'uploads/cte/pdf/' . $cte['codigo'] . '.pdf';
    $filename = realpath($arquivo);
    if (is_file($filename)) {
      $this->view->pdf = $arquivo;
    }

    $arquivo = 'uploads/cte/pdf/' . $cte['codigo'] . '-preview.pdf';
    $filename = realpath($arquivo);
    if (is_file($filename)) {
      $this->view->pdfpreview = $arquivo;
    }
    $this->view->data['id'] = $cte_id;
  }

  public function formenviararquivosAction()
  {
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);
    $ClientesModel = new Clientes_Model();
    $dados = $this->_getAllParams();
    $cliente = $ClientesModel->find($cte['cliente_id']);
    $form = WS_Form_Generator::generateForm('EnviarArquivos', $this->model->getFormFieldsArquivos($cte_id, $cliente['email'] . ';acquasana@acquasana.com.br'));
    if ($this->_request->isPost()):
      if ($this->_hasParam('destinatarios')):
        if ($form->isValid($this->_request->getPost())) :
          if (date('H') > 12):
            $saudacao = 'Boa tarde';
          else:
            $saudacao = 'Bom dia';
          endif;

          $WD = new WS_Date();

          $EmpresasModel = new Empresas_Model();
          $empresa = $EmpresasModel->find(3);

          $EstadosModel = new Estados_Model();
          $estado = $EstadosModel->find($empresa['estado_id']);
          $link = 'http://www.acquasana.com.br/erp/Boleto-Itau/cte-acquaservicos/' . base64_encode($cte_id);

          $emailConteudo['descricao'] = '<p>' . $saudacao . ', ' . $cliente['contato'] . '</p>
                            <p>' . nl2br($dados['mensagem']) . '</p>';

          $OrdensServicoModel = new OrdensServico_Model();
          $selecionados = $OrdensServicoModel->buscarPorCteAcquaservicos($cte_id);
          if (!empty($selecionados)):
            $emailConteudo['descricao'] .= '<p>CT-e referente às Ordens de Serviço: <b>';
            foreach ($selecionados AS $selecionado):
              $emailConteudo['descricao'] .= $selecionado['orcamento_id'] . '.' . $selecionado['sequencial'] . ' ';
            endforeach;
            $emailConteudo['descricao'] .= '</b></p>';
          endif;

          $emailConteudo['descricao'] .= '<p>As suas faturas referentes a essa CT-e podem ser consultadas em <a href="' . $link . '">' . $link . '</a>.</p>
                    <p>Att,<br />
                    ' . $empresa['razao_social'] . '<br />
                    ' . $empresa['endereco'] . ', ' . $empresa['numero'] . '<br />
                    CEP: ' . $empresa['cep'] . '  |  ' . $empresa['cidade'] . '-' . $estado['uf'] . '<br />
                    Fone: ' . $empresa['telefone'] . '</p>
                    <p>Email: <a href="mailto:' . $empresa['email'] . '">' . $empresa['email'] . '</a><br />
                    Site: <a href="' . $empresa['website'] . '">' . $empresa['website'] . '</a></p>';

          try {
            $mail = new Email_Model('UTF-8');

            $this->view->conteudo = $emailConteudo;
            $body = $this->view->render('emails/cte.phtml');

            $mail->setBodyHtml($body, 'utf-8');
            $mail->setSubject($dados['assunto']);
            $destinatarios = explode(';', $dados['destinatarios']);

            foreach ($destinatarios AS $destinatario):
              $mail->addTo($destinatario);
            endforeach;

            $mail->addBcc('acquasana@acquasana.com.br');
            $mail->setReplyTo('acquasana@acquasana.com.br');

            $arquivo = 'uploads/cte/xml/' . $cte['codigo'] . '-proc.xml';
            $filename = realpath($arquivo);
            if (is_file($filename)) :
              $at = new Zend_Mime_Part(file_get_contents($arquivo));
              $at->type = 'application/xml';
              $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
              $at->encoding = Zend_Mime::ENCODING_BASE64;
              $at->filename = $cte['codigo'] . '.xml';
              $mail->addAttachment($at);
            endif;

            $arquivo = 'uploads/cte/pdf/' . $cte['codigo'] . '.pdf';
            $filename = realpath($arquivo);
            if (is_file($filename)) :
              $at = new Zend_Mime_Part(file_get_contents($arquivo));
              $at->type = 'application/pdf';
              $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
              $at->encoding = Zend_Mime::ENCODING_BASE64;
              $at->filename = $cte['codigo'] . '.pdf';
              $mail->addAttachment($at);
            endif;

            $arquivo = 'uploads/cte/Faturas_Acquaservicos_' . $cte['id'] . '.pdf';
            $filename = realpath($arquivo);
            if (is_file($filename)) :
              $at = new Zend_Mime_Part(file_get_contents($arquivo));
              $at->type = 'application/pdf';
              $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
              $at->encoding = Zend_Mime::ENCODING_BASE64;
              $at->filename = 'Faturas_Acquaservicos_' . $cte['id'] . '.pdf';
              $mail->addAttachment($at);
            endif;

            $OrdensServicoModel = new OrdensServico_Model();
            $ordenservico = $OrdensServicoModel->getByCteAcquaservicos($cte_id);

            if (!empty($ordenservico)):
              foreach ($ordenservico AS $ordem):
                $ordem['file'] = 'Relatorio_' . $ordem['id'] . '.pdf';
                $arquivo = 'uploads/ordem-servico/' . $ordem['file'];
                $filename = realpath($arquivo);
                if (is_file($filename)) :
                  $at = new Zend_Mime_Part(file_get_contents($arquivo));
                  $at->type = 'application/pdf';
                  $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                  $at->encoding = Zend_Mime::ENCODING_BASE64;
                  $at->filename = $ordem['file'];
                  $mail->addAttachment($at);
                endif;
              endforeach;

              $this->view->arquivosOs = $arquivosOs;
            endif;

            $mail->envia('acquasana@acquasana.com.br', 'Acquasana');

            $dados = null;
            $dados['status'] = 7;
            $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
            $this->model->_db->update($dados, $where);

            $this->alerta('sucess', 'E-mail enviado com sucesso!');
          } catch (Zend_Mail_Exception $e) {
            $this->alerta('error', $e->getMessage());
          }
        else:
          $this->alerta('error', 'Verifique os dados informados!');
          $form->populate($dados);
          $this->view->form = $form;
        endif;
      else:
        $this->alerta('error', 'Preencha todos os dados corretamente!');
        $form->populate($dados);
        $this->view->form = $form;
      endif;
    else:
      $this->view->form = $form;
    endif;
  }

  public function cancelarAction()
  {
    $cte_id = $this->_getParam('cte_id');
    $cte = $this->model->find($cte_id);
    $protocolo = $cte['protocolo_sefaz'];
    $codigo = $cte['codigo'];
    try {
      $cte = new CTeNFePHP();
//            $cte->setEmpresa('Acquaservicos');
      $aResp = $cte->cancelEvent($codigo, $protocolo, 'Dados Incorretos');
      if ($aResp['bStat']) {
        $this->alerta('sucess', 'CTE cancelada com sucesso!');
        $data['status'] = 8;
        $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte_id);
        $this->model->_db->update($data, $where);

        $data = null;
        $ContasReceberModel = new ContasReceber_Model();
        $data['cte_acquaservicos_id'] = null;
        $where = $ContasReceberModel->_db->getAdapter()->quoteInto('cte_acquaservicos_id = ?', $cte_id);
        $ContasReceberModel->_db->update($data, $where);

        $this->alerta('sucess', 'Cte cancelada sucesso!');
      } else {
        var_dump($aResp);
        $this->alerta('error', 'Houve erro !! ' . $aResp['xMotivo']);
      }
    } catch (Exception $e) {
      $this->alerta('error', $e->getMessage());
    }
    exit();
  }

  public function importarAction()
  {
    $WSF = new WS_FOLDER();
    $folder = 'uploads/cte/xml/';
    $arquivos = $WSF->read($folder);
    if (!empty($arquivos)):
      foreach ($arquivos AS $arquivo):
        $extensao = substr($arquivo['file'], -9);
        if ($extensao == '-proc.xml'):
          $id = substr($arquivo['file'], 25, 9);
          $chave = substr($arquivo['file'], 36, 8);
          $codigo = substr($arquivo['file'], 0, 44);
          $retorno[$id]['chave'] = $chave;
          $retorno[$id]['id'] = intval($id);
          $retorno[$id]['codigo'] = $codigo;
          $retorno[$id]['status'] = 4;
          $retorno[$id]['data'] = '2013-03-20';
          $retorno[$id]['cfop_id'] = '1';
          $retorno[$id]['cliente_id'] = '4';
          $retorno[$id]['endereco_id'] = '1';
          $retorno[$id]['transportador_id'] = '1';
        endif;
      endforeach;
      if (!empty($retorno)):
        foreach ($retorno AS $data):
          $this->model->_db->insere($data, $this->model->getOption('actions', 'add'), $this->model->_db->getTableName());
        endforeach;
        echo 'CT-es importadas com sucesso';
      endif;
    endif;
    exit();
  }

  public function importarCteAction()
  {
    $ClientesModel = new Clientes_Model();
    $this->view->clientes = $ClientesModel->listagem();


    if ($this->_request->isPost()) {
      $data = $this->_request->getParams();

      if (!empty($data['cliente_id'])) {
        if (!empty($_FILES['xml'])) {
          $xml_content = file_get_contents($_FILES['xml']['tmp_name']);
          $xml_content = simplexml_load_string($xml_content);
          $codigo = (string)$xml_content->protCTe->infProt->chCTe;

          $upload = new Upload($_FILES['xml']);
          if ($upload->uploaded) {
            $upload->file_overwrite = true;
            $upload->file_new_name_body = $codigo . '-proc';
            $upload->Process(UPLOAD_PATH . '/cte/xml/');
            if ($upload->processed) {
              $xml = $upload->file_dst_name;
            }
          } else {
            echo 'error : ' . $upload->error;
          }

          if (!empty($_FILES['pdf'])) {
            $upload = new Upload($_FILES['pdf']);
            if ($upload->uploaded) {
              $upload->file_overwrite = true;
              $upload->file_new_name_body = $codigo;
              $upload->Process(UPLOAD_PATH . '/cte/pdf/');
              if ($upload->processed) {
                $pdf = $upload->file_dst_name;
              } else {
                echo 'error : ' . $upload->error;
              }
            }
          }
          $cte['id'] = $data['cte_id'];
          $cte['cliente_id'] = $data['cliente_id'];
          $cte['endereco_id'] = 27; // número qualquer
          $cte['destinatario_id'] = 309;
          $cte['destinatario_endereco_id'] = 475;
          $cte['status'] = 7;
          $cte['cfop_id'] = 2;
          $cte['rtnrc'] = 12467693;
          $cte['codigo'] = $codigo;
          $cte['chave'] = (string)$xml_content->CTe->infCte->ide->cCT;
          $cte['quantidade'] = (string)$xml_content->CTe->infCte->infCTeNorm->infCarga->infQ->qCarga;
          $cte['created'] = date('Y-m-d');
          $cte['data'] = (string) $xml_content->CTe->infCte->ide->dhEmi;

          $verifica = $this->model->find($cte['id']);
          if (!empty($verifica)) {
            $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $cte['id']);
            $this->model->_db->update($cte, $where);
          } else {
            $this->model->_db->insert($cte);
          }

          if (!empty($data['conta'])) {
            $ContasReceberModel = new ContasReceber_Model();
            $dados['cte_acquaservicos_id'] = $cte['id'];
            foreach ($data['conta'] as $conta => $value) {
              $where = $this->model->_db->getAdapter()->quoteInto('id = ?', $conta);
              $ContasReceberModel->_db->update($dados, $where);
            }
          }

          $this->alerta('sucess', 'CT-e Importada com sucesso!');
        }
      }
    }
  }

}
