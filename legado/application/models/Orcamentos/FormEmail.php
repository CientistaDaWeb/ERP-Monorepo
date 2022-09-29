<?php

class Orcamentos_FormEmail extends Zend_Form {

    public function init() {
        $TextosModel = new Textos_Model();

        $this->setMethod('POST')
                ->setAttrib('id', 'OrcamentosEmailForm');

        $id = new WS_Form_Element_Hidden('orcamento_id');

        $destinatarios = new WS_Form_Element_Text('destinatarios');
        $destinatarios->setRequired(true)
                ->removeDecorator('label');

        $assunto_id = new WS_Form_Element_Select('assunto_id');
        $assunto_id->setRequired(false)
                ->setIgnore(true)
                ->removeDecorator('label');
        $assunto_id->addMultiOption('', 'Usar Modelo');
        $assunto_id->addMultiOptions($TextosModel->getByCategoria(6));

        $assunto = new WS_Form_Element_Text('assunto');
        $assunto->setRequired(true)
                ->removeDecorator('label');

        $descricao_id = new WS_Form_Element_Select('descricao_id');
        $descricao_id->setRequired(false)
                ->setIgnore(true)
                ->removeDecorator('label');
        $descricao_id->addMultiOption('', 'Usar Modelo');
        $descricao_id->addMultiOptions($TextosModel->getByCategoria(7));

        $descricao = new WS_Form_Element_Textarea('descricao');
        $descricao->setRequired(true)
                ->removeDecorator('label');

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Enviar por e-mail');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $destinatarios,
            $assunto_id,
            $assunto,
            $descricao_id,
            $descricao,
            $salvar,
            $cancelar
        ));

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
                array('descricao_id', 'descricao'), 'groupDescricao', array(
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

