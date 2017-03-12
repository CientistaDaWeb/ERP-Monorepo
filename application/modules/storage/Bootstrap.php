<?php

class Storage_Bootstrap extends Zend_Application_Module_Bootstrap {

    protected function _initRotes() {
        $module = 'storage';
        $this->controller = Zend_Controller_Front::getInstance();
        $this->router = $this->controller->getRouter();
        $this->router->addRoute('storage-imagem', new Zend_Controller_Router_Route($module . '/imagem/:file/:folder', array(
                    'controller' => 'Img',
                    'action' => 'index',
                    'module' => $module,
                    'folder' => 'default',
                    'file' => 'default.jpg'
                )));
        $this->router->addRoute('storage-file', new Zend_Controller_Router_Route($module . '/file/:file/:folder/:mode', array(
                    'controller' => 'File',
                    'action' => 'get',
                    'module' => $module,
                    'mode' => 'save'
                )));
    }

    protected function _initHelpers() {
        $view = new Zend_View();
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->addHelperPath("WS/View/Helper", "WS_View_Helper");

        $viewRender = new Zend_Controller_Action_Helper_ViewRenderer($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRender);
    }

}
