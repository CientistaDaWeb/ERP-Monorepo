<?php

class FaleConosco_Form extends Zend_Form {

    public function init() {
        $estadosModel = new Estados_Model();

        $this->setAttrib('id', 'fale-conosco-form')
                ->setAction('fale-conosco')
                ->setMethod('post');
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => true,
            'placeholder' => 'NOME *',
        ));
        $this->addElement('text', 'email', array(
            'label' => 'E-mail',
            'required' => true,
            'validators' => array(
                'EmailAddress'
            ),
            'placeholder' => 'E-MAIL *',
        ));
        $this->addElement('text', 'telefone', array(
            'label' => 'Telefone',
            'required' => true,
            'placeholder' => 'TELEFONE *',
        ));
        $this->addElement('text', 'cidade', array(
            'label' => 'Cidade',
            'required' => true,
            'placeholder' => 'CIDADE *',
        ));
        $this->addElement('text', 'estado', array(
            'label' => 'estado',
            'required' => true,
            'placeholder' => 'ESTADO *',
        ));
        /*
        $this->addElement('select', 'estado', array(
            'label' => 'Estado',
            'multiOptions' => $estadosModel->getEstadosPair(),
                'required' => true,
            'placeholder' => 'ESTADO *',
        ));
         *
         */
        $this->addElement('textarea', 'mensagem', array(
            'label' => 'Mensagem',
            'rows' => '7',
            'cols' => '35',
            'required' => true,
            'placeholder' => 'MENSAGEM *',
        ));
        $this->addElement('button', 'enviar', array(
            'ignore' => true,
            'label' => 'Enviar'
        ));
        $this->getElement('enviar')->removeDecorator('label')->removeDecorator('DtDdWrapper')->setAttrib('type', 'submit');
    }

}