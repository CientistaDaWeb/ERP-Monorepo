<?php

class AuthCliente_Form extends Zend_Form {

    public function init() {
        $this->setMethod('POST');
        $this->setAttrib('id', 'Form_Login');

        $usuario = new WS_Form_Element_Text('usuario');
        $usuario->setRequired(true)
                ->setLabel('Usuário')
                ->addValidators(array(
                    'NotEmpty'
                ));

        $senha = new WS_Form_Element_Password('senha');
        $senha->setRequired(true)
                ->setLabel('Senha')
                ->addValidators(array(
                    'NotEmpty'
                ));

        $entrar = new WS_Form_Element_Submit('entrar');
        $entrar->setValue('Logar');

        $this->addElements(array(
            $usuario,
            $senha,
            $entrar
        ));
    }

}

