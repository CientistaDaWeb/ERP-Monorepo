<?php

class Cliente_Controller_Action extends WS_Controller_Action {

    public function init() {
        parent::init();

        $auth = new WS_Auth('cliente');

        if ($this->_request->getControllerName() != 'Auth'):
            if ($auth->hasIdentity()) :
                $this->view->User = $auth->getIdentity();
            else:
                $this->_redirect('/cliente/Auth');
            endif;
        endif;
    }

}