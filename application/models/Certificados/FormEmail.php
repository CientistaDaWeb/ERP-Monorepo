<?php

class Certificados_FormEmail extends Zend_Form {

    public function init() {
        $TextosModel = new Textos_Model();

        $this->setMethod('POST')
                ->setAttrib('id', 'CertificadosEmailForm');

        $id = new WS_Form_Element_Hidden('certificado_id');

        $remetente = new WS_Form_Element_Select('remetente');
        $remetente->setRequired(true)
                ->removeDecorator('label');
        $remetente->addMultiOption('', 'Usar o gerador do Orçamento');
        $remetente->addMultiOptions(Usuarios_Model::fetchPair());

        $destinatarios = new WS_Form_Element_Text('destinatarios');
        $destinatarios->setRequired(true)
                ->removeDecorator('label');

        $assunto_id = new WS_Form_Element_Select('assunto_id');
        $assunto_id->setRequired(false)
                ->setIgnore(true)
                ->removeDecorator('label');
        $assunto_id->addMultiOption('', 'Usar Modelo');
        $assunto_id->addMultiOptions($TextosModel->getByCategoria(4));

        $assunto = new WS_Form_Element_Text('assunto');
        $assunto->setRequired(true)
                ->removeDecorator('label');

        $descricao_id = new WS_Form_Element_Select('descricao_id');
        $descricao_id->setRequired(false)
                ->setIgnore(true)
                ->removeDecorator('label');
        $descricao_id->addMultiOption('', 'Usar Modelo');
        $descricao_id->addMultiOptions($TextosModel->getByCategoria(5));

        $descricao = new WS_Form_Element_Textarea('descricao');
        $descricao->setRequired(false)
                ->removeDecorator('label');

        $criar_atendimento = new WS_Form_Element_Select('criar_atendimento');
        $criar_atendimento->setRequired(false)
                ->setLabel('Criar atendimento');
        $criar_atendimento->addMultiOptions(array('S' => 'Sim', 'N' => 'Não'));

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Enviar por e-mail');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $remetente,
            $destinatarios,
            $assunto_id,
            $assunto,
            $descricao_id,
            $descricao,
            $criar_atendimento,
            $salvar,
            $cancelar
        ));

        $this->addDisplayGroup(
                array('remetente'), 'groupRemente', array(
            'legend' => 'Remetente'
                )
        );
        $this->addDisplayGroup(
                array('destinatarios'), 'groupDestinatario', array(
            'legend' => 'Destinatários'
                )
        );
        $this->addDisplayGroup(
                array('assunto_id', 'assunto'), 'groupAssunto', array(
            'legend' => 'Assunto'
                )
        );

        $this->addDisplayGroup(
                array('descricao_id', 'descricao', 'criar_atendimento'), 'groupDescricao', array(
            'legend' => 'Descrição'
                )
        );

        $this->addDisplayGroup(
                array('salvar', 'cancelar'), 'botoes'
        );

        $this->setDisplayGroupDecorators(array(
            'FormElements',
            'Fieldset'
        ));
    }

}

