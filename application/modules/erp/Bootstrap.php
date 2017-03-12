<?php

class Erp_Bootstrap extends Zend_Application_Module_Bootstrap {

    protected function _initRotes() {
        $module = 'erp';
        $this->controller = Zend_Controller_Front::getInstance();
        $this->router = $this->controller->getRouter();
        $this->router->addRoute('erp', new Zend_Controller_Router_Route($module . '/:controller/:action', array(
                    'controller' => 'Index',
                    'action' => 'index',
                    'module' => $module
                )));
        $this->router->addRoute('logout', new Zend_Controller_Router_Route($module . '/logout', array(
                    'controller' => 'Auth',
                    'action' => 'logout',
                    'module' => $module
                )));

        $this->router->addRoute('modulo', new Zend_Controller_Router_Route($module . '/:controller/:action/:id/:parent_id', array(
                    'module' => $module,
                    'id' => '',
                    'parent_id' => '',
                )));
        $this->router->addRoute('submodulo', new Zend_Controller_Router_Route($module . '/submodulo/:controller/:action/:id/:parent_id', array(
                    'module' => $module,
                    'submodulo' => true,
                    'id' => '',
                    'parent_id' => '',
                )));
        $this->router->addRoute('print', new Zend_Controller_Router_Route($module . '/print/:controller/:action/:id/:parent_id', array(
                    'module' => $module,
                    'print' => true,
                    'parent_id' => '',
                    'id' => ''
                )));
        $this->router->addRoute('save', new Zend_Controller_Router_Route($module . '/save/:controller/:action/:id/:parent_id/:timbrado', array(
                    'module' => $module,
                    'save' => true,
                    'parent_id' => '',
                    'id' => '',
                    'timbrado' => false
                )));
        $this->router->addRoute('boleto-itau', new Zend_Controller_Router_Route($module . '/Boleto-Itau/:action/:id', array(
                    'module' => $module,
                    'controller' => 'Boleto-Itau',
                    'id' => '',
                )));
    }

    protected function _initHelpers() {
        $view = new Zend_View();
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->addHelperPath("WS/View/Helper", "WS_View_Helper");
        $view->addHelperPath("Erp/View/Helper", "Erp_View_Helper");
        $view->addHelperPath("Default/View/Helper", "Default_View_Helper");

        $viewRender = new Zend_Controller_Action_Helper_ViewRenderer($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRender);
    }

}
