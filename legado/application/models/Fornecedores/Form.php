<?php

class Fornecedores_Form extends Zend_Form {

    public function init() {

        $FornecedoresCategoriasModel = new FornecedoresCategorias_Model();
        $EstadosModel = new Estados_Model();

        $this->setMethod('POST')
                ->setAttrib('id', 'FornecedoresForm');

        $id = new WS_Form_Element_Hidden('id');

        $categoria_id = new WS_Form_Element_Select('categoria_id');
        $categoria_id->setRequired(true)
                ->setLabel('Categoria');
        $categoria_id->addMultiOption('', 'Selecione');
        $categoria_id->addMultiOptions($FornecedoresCategoriasModel->fetchPair());

        $documento = new WS_Form_Element_Cnpj('documento');
        $documento->setRequired(false)
                ->setLabel('CNPJ');

        $inscricao_estadual = new WS_Form_Element_Text('inscricao_estadual');
        $inscricao_estadual->setRequired(false)
                ->setLabel('Inscrição Estadual');

        $inscricao_municipal = new WS_Form_Element_Text('inscricao_municipal');
        $inscricao_municipal->setRequired(false)
                ->setLabel('Inscrição Municipal');

        $razao_social = new WS_Form_Element_Text('razao_social');
        $razao_social->setRequired(true)
                ->setLabel('Razão Social / Nome');

        $nome_fantasia = new WS_Form_Element_Text('nome_fantasia');
        $nome_fantasia->setRequired(false)
                ->setLabel('Nome Fantasia / Apelido');

        $email = new WS_Form_Element_Mail('email');
        $email->setRequired(false)
                ->setLabel('E-mail');

        $numero_fepan = new WS_Form_Element_Text('numero_fepan');
        $numero_fepan->setRequired(false)
                ->setLabel('Nº Fepan');

        $estado_id = new WS_Form_Element_Select('estado_id');
        $estado_id->setRequired(true)
                ->setLabel('Estado');
        $estado_id->addMultiOptions($EstadosModel->fetchPair());

        $cep = new WS_Form_Element_Cep('cep');
        $cep->setRequired(false)
                ->setLabel('Cep');

        $cidade = new WS_Form_Element_Text('cidade');
        $cidade->setRequired(false)
                ->setLabel('Cidade');

        $endereco = new WS_Form_Element_Text('endereco');
        $endereco->setRequired(false)
                ->setLabel('Endereço');

        $bairro = new WS_Form_Element_Text('bairro');
        $bairro->setRequired(false)
                ->setLabel('Bairro');

        $numero = new WS_Form_Element_Number('numero');
        $numero->setRequired(false)
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

        $banco = new WS_Form_Element_Text('banco');
        $banco->setRequired(false)
                ->setLabel('Banco');

        $agencia = new WS_Form_Element_Text('agencia');
        $agencia->setRequired(false)
                ->setLabel('Agência');

        $conta_corrente = new WS_Form_Element_Text('conta_corrente');
        $conta_corrente->setRequired(false)
                ->setLabel('Conta Corrente');

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Button('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $categoria_id,
            $documento,
            $razao_social,
            $nome_fantasia,
            $inscricao_estadual,
            $inscricao_municipal,
            $email,
            $numero_fepan,
            $estado_id,
            $cep,
            $cidade,
            $endereco,
            $numero,
            $complemento,
            $bairro,
            $telefone,
            $telefone2,
            $telefone3,
            $banco,
            $agencia,
            $conta_corrente,
            $salvar,
            $cancelar
        ));
    }

}

