<?php

$configs = Zend_Registry::get('application');
/**
 * Parâmetros de configuração do sistema
 * Última alteração em 26-02-2013 08:44:41
 * */
//###############################
//########## GERAL ##############
//###############################
// tipo de ambiente esta informação deve ser editada pelo sistema
// 1-Produção 2-Homologação
// esta variável será utilizada para direcionar os arquivos e
// estabelecer o contato com o SEFAZ
$ambiente = $configs->cte->ambiente->codigo;
//esta variável contêm o nome do arquivo com todas as url dos webservices do sefaz
//incluindo a versao dos mesmos, pois alguns estados não estão utilizando as
//mesmas versões
$arquivoURLxml = "nfe_ws2.xml";
$arquivoURLxmlCTe = "cte_ws2.xml";
//Diretório onde serão mantidos os arquivos com as NFe em xml
//a partir deste diretório serão montados todos os subdiretórios do sistema
//de manipulação e armazenamento das NFe e CTe
$arquivosDir = realpath("uploads/nfe");
$arquivosDirCTe = realpath("uploads/cte");
//URL base da API, passa a ser necessária em virtude do uso dos arquivos wsdl
//para acesso ao ambiente nacional

$baseurl = $configs->cliente->dominio;
//Versão em uso dos schemas utilizados para validação dos xmls
$schemes = "PL_008d";
$schemesCTe = "PL_CTe_200";

//###############################
//###### EMPRESA EMITENTE #######
//###############################
//Nome da Empresa
$empresa = "Acqualife Serviços e Transportes Eireli - EPP";
//Sigla da UF
$UF = "RS";
//Código da UF
$cUF = "43";
//Número do CNPJ
$cnpj = "23661925000189";

//###############################
//#### CERITIFICADO DIGITAL #####
//###############################
//Nome do certificado que deve ser colocado na pasta certs da API
$certName = "CER-A1-Acqualife.pfx";
//Senha da chave privada
$keyPass = "A30553686";
//Senha de decriptaçao da chave, normalmente não é necessaria
$passPhrase = "";

//###############################
//############ DANFE ############
//###############################
//Configuração do DANFE
$danfeFormato = "P"; //P-Retrato L-Paisagem
$danfePapel = "A4"; //Tipo de papel utilizado
$danfeCanhoto = 1; //se verdadeiro imprime o canhoto na DANFE
$danfeLogo = "images/logo_dacte.jpg"; //passa o caminho para o LOGO da empresa
$danfeLogoPos = "L"; //define a posição do logo na Danfe L-esquerda, C-dentro e R-direta
$danfeFonte = "Times"; //define a fonte do Danfe limitada as fontes compiladas no FPDF (Times)
$danfePrinter = "hpteste"; //define a impressora para impressão da Danfe
//###############################
//############ DACTE ############
//###############################
//Configuração do DACTE
$dacteFormato = "P"; //P-Retrato L-Paisagem
$dactePapel = "A4"; //Tipo de papel utilizado
$dacteCanhoto = 1; //se verdadeiro imprime o canhoto na DANFE
$dacteLogo = "images/logo_dacte.jpg"; //passa o caminho para o LOGO da empresa
$dacteLogoPos = "L"; //define a posição do logo na Danfe L-esquerda, C-dentro e R-direta
$dacteFonte = "Times"; //define a fonte do Danfe limitada as fontes compiladas no FPDF (Times)
$dactePrinter = "hpteste"; //define a impressora para impressão da Dacte
//###############################
//############ EMAIL ############
//###############################
//Configuração do email
$mailAuth = "1"; //ativa ou desativa a obrigatoriedade de autenticação no envio de email, na maioria das vezes ativar
//$mailFROM = "nfe@acquasana.com.br"; //identificação do emitente
$mailFROM = $configs->email->username; //identificação do emitente
//$mailHOST = "smtp.gmail.com"; //endereço do servidor SMTP
$mailHOST = $configs->email->host; //endereço do servidor SMTP
//$mailUSER = "no-reply@acquasana.com.br"; //username para autenticação, usando quando mailAuth é 1
$mailUSER = $configs->email->username; //username para autenticação, usando quando mailAuth é 1
//$mailPASS = "4aw8g4qhpt"; //senha de autenticação do serviço de email
$mailPASS = $configs->email->password; //senha de autenticação do serviço de email
//$mailPROTOCOL = ""; //protocolo de email utilizado (classe alternate)
$mailPROTOCOL = $configs->email->ssl; //protocolo de email utilizado (classe alternate)
//$mailPORT = "485"; //porta utilizada pelo smtp (classe alternate)
$mailPORT = $configs->email->port; //porta utilizada pelo smtp (classe alternate)
//$mailFROMmail = "nfe@acquasana.com.br"; //para alteração da identificação do remetente, pode causar problemas com filtros de spam
$mailFROMmail = $configs->email->username; //para alteração da identificação do remetente, pode causar problemas com filtros de spam
$mailFROMname = "NFe Acquasana"; //para indicar o nome do remetente
$mailREPLYTOmail = "nfe@acquasana.com.br"; //para indicar o email de resposta
$mailREPLYTOname = "NFe Acquasana"; //para indicar email de cópia
$mailIMAPhost = "imap.gmail.com"; //url para o servidor IMAP
$mailIMAPport = "143"; //porta do servidor IMAP
$mailIMAPsecurity = "tls"; //esquema de segurança do servidor IMAP
$mailIMAPnocerts = "novalidate-cert"; //desabilita verificação de certificados do Servidor IMAP
$mailIMAPbox = "INBOX"; //caixa postal de entrada do servidor IMAP
$mailLayoutFile = ""; //layout da mensagem do email
//###############################
//############ PROXY ############
//###############################
//Configuração de Proxy
$proxyIP = ""; //ip do servidor proxy, se existir
$proxyPORT = ""; //numero da porta usada pelo proxy
$proxyUSER = ""; //nome do usuário, se o proxy exigir autenticação
$proxyPASS = ""; //senha de autenticação do proxy
?>