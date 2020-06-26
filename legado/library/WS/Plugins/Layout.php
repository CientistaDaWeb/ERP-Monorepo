<?php

class WS_Plugins_Layout extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $layout = Zend_Layout::startMvc();
        $layout->setLayout($request->getModuleName())
                ->setLayoutPath(APPLICATION_PATH . '/modules/' . $request->getModuleName() . '/layouts');
    }

}