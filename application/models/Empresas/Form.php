<?php

class Empresas_Form extends Zend_Form {

    public function init() {

        $EstadosModel = new Estados_Model();

        $this->setMethod('POST')
                ->setAttrib('id', 'EmpresasForm');

        $id = new WS_Form_Element_Hidden('id');

        $documento = new WS_Form_Element_Cnpj('documento');
        $documento->setRequired(true)
                ->setLabel('CNPJ');

        $inscricao_estadual = new WS_Form_Element_Text('inscricao_estadual');
        $inscricao_estadual->setRequired(true)
                ->setLabel('Inscrição Estadual');

        $inscricao_municipal = new WS_Form_Element_Text('inscricao_municipal');
        $inscricao_municipal->setRequired(true)
                ->setLabel('Inscrição Municipal');

        $razao_social = new WS_Form_Element_Text('razao_social');
        $razao_social->setRequired(true)
                ->setLabel('Razão Social / Nome');

        $nome_fantasia = new WS_Form_Element_Text('nome_fantasia');
        $nome_fantasia->setRequired(true)
                ->setLabel('Nome Fantasia / Apelido');

        $email = new WS_Form_Element_Mail('email');
        $email->setRequired(true)
                ->setLabel('E-mail');

        $site = new WS_Form_Element_Url('site');
        $site->setRequired(false)
                ->setLabel('Website');

        $numero_fepan = new WS_Form_Element_Text('numero_fepan');
        $numero_fepan->setRequired(false)
                ->setLabel('Nº Fepan');

        $estado_id = new WS_Form_Element_Select('estado_id');
        $estado_id->setRequired(true)
                ->setLabel('Estado');
        $estado_id->addMultiOption('', 'Selecione o Estado');
        $estado_id->addMultiOptions(Estados_Model::fetchPair());

        $cep = new WS_Form_Element_Cep('cep');
        $cep->setRequired(true)
                ->setLabel('Cep');

        /*
          $cidade = new WS_Form_Element_Text('cidade');
          $cidade->setRequired(true)
          ->setLabel('Cidade');
         */

        $municipio_id = new WS_Form_Element_Select('municipio_id');
        $municipio_id->setRequired(true)
                ->setLabel('Município');
        $municipio_id->addMultiOptions(Municipios_Model::fetchPair());

        $endereco = new WS_Form_Element_Text('endereco');
        $endereco->setRequired(true)
                ->setLabel('Endereço');

        $bairro = new WS_Form_Element_Text('bairro');
        $bairro->setRequired(true)
                ->setLabel('Bairro');

        $numero = new WS_Form_Element_Number('numero');
        $numero->setRequired(true)
                ->setLabel('Número');

        $complemento = new WS_Form_Element_Text('complemento');
        $complemento->setRequired(false)
                ->setLabel('Complemento');

        $telefone = new WS_Form_Element_Phone('telefone');
        $telefone->setRequired(false)
                ->setLabel('Telefone');

        $telefone2 = new WS_Form_Element_Phone('telefone2');
        $telefone2->setRequired(false)
                ->setLabel('Telefone 2');

        $telefone3 = new WS_Form_Element_Phone('telefone3');
        $telefone3->setRequired(false)
                ->setLabel('Telefone 3');

        $logomarca = new Zend_Form_Element_File('logo');
        $logomarca->setRequired(false)
                ->setIgnore(true)
                ->setLabel('Enviar um logo')
                ->setAttribs(array(
                    'class' => array(
                        'ui-corner-all'
                    )
                ))
                ->addValidator('Count', false, 1)
                ->addValidator('Size', false, 512000)
                ->addValidator('Extension', false, 'jpg,png,gif');

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $documento,
            $razao_social,
            $nome_fantasia,
            $inscricao_estadual,
            $inscricao_municipal,
            $email,
            $site,
            $numero_fepan,
            $estado_id,
            $municipio_id,
            $cep,
            $endereco,
            $numero,
            $complemento,
            $bairro,
            $telefone,
            $telefone2,
            $telefone3,
            $logomarca,
            $salvar,
            $cancelar
        ));
    }

}

