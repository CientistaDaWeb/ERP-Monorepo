<?php

class Zend_View_Helper_ClienteMenu extends Zend_View_Helper_Navigation {

    public function ClienteMenu() {
        $auth = new WS_Auth('cliente');
        if ($auth->hasIdentity()) :
            $usuario = $auth->getIdentity();
            $module = 'erp';

            $page[] = array(
                'uri' => '/cliente/Certificados/',
                'order' => -100,
                'label' => 'Certificados',
                'title' => 'Certificados'
            );

            $container = new Zend_Navigation($page);
            $this->setContainer($container);
        endif;

        return $this;
    }

}

