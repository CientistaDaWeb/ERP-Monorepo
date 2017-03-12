<?php

class Cliente_Bootstrap extends Zend_Application_Module_Bootstrap {

    protected function _initRotes() {
        $module = 'cliente';
        $this->controller = Zend_Controller_Front::getInstance();
        $this->router = $this->controller->getRouter();
        $this->router->addRoute('cliente', new Zend_Controller_Router_Route($module . '/:controller/:action', array(
            'controller' => 'Index',
            'action' => 'index',
            'module' => $module
        )));
        $this->router->addRoute('cliente-logout', new Zend_Controller_Router_Route($module . '/logout', array(
            'controller' => 'Auth',
            'action' => 'logout',
            'module' => $module
        )));
        $this->router->addRoute('cliente-modulo', new Zend_Controller_Router_Route($module . '/:controller/:action/:id', array(
            'module' => $module,
            'id' => ''
        )));
        $this->router->addRoute('pesquisa-satisfacao', new Zend_Controller_Router_Route($module . '/pesquisa/:id', array(
            'module' => $module,
            'controller' => 'Pesquisa',
            'action' => 'index',
            'id' => ''
        )));
    }

    protected function _initHelpers() {
        $view = new Zend_View();
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->addHelperPath("WS/View/Helper", "WS_View_Helper");
        $view->addHelperPath("Cliente/View/Helper", "Cliente_View_Helper");
        $view->addHelperPath("Default/View/Helper", "Default_View_Helper");

        $viewRender = new Zend_Controller_Action_Helper_ViewRenderer($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRender);
    }

}
