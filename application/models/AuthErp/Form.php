<?php

class AuthErp_Form extends Zend_Form {

    public function init() {
        $this->setMethod('POST');
        $this->setAttrib('id', 'AuthForm');

        $usuario = new WS_Form_Element_Text('usuario');
        $usuario->setRequired(true)
                ->setLabel('Usuário');

        $senha = new WS_Form_Element_Password('senha');
        $senha->setRequired(true)
                ->setLabel('Senha');

        $entrar = new WS_Form_Element_Submit('entrar');
        $entrar->setValue('Logar');

        $this->addElements(array(
            $usuario,
            $senha,
            $entrar
        ));
    }

}

