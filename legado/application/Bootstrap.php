<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAutoLoader() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('WS');
        $autoloader->registerNamespace('Phpmailer');
        $autoloader->registerNamespace('Erp');
        $autoloader->registerNamespace('Cliente');
        $autoloader->registerNamespace('ZFDebug');
        $autoloader->registerNamespace('ZendX');
        $autoloader->registerNamespace('Storage');
        $autoloader->setFallbackAutoloader(true);
        return $autoloader;
    }

    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initConfigs() {
        $application = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::set('application', $application);
    }

    protected function _initRedirect() {
        $configs = Zend_Registry::get('application');

        if ($_SERVER['SERVER_ADDR'] == $configs->cliente->ip) :
            if ($_SERVER['HTTP_HOST'] != 'www.' . $configs->cliente->dominio) :
                $url = $_SERVER['REQUEST_URI'];
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: http://www.' . $configs->cliente->dominio . $url);
            endif;
        endif;
    }

    protected function _initTranslate() {
        $translator = new Zend_Translate(array('adapter' => 'array', 'content' => '../library/Translate/Validate/', 'locale' => 'pt_BR', 'scan' => Zend_Translate::LOCALE_DIRECTORY));
        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }

    protected function _initLocale() {
        $locale = new Zend_Locale();
        $locale->setLocale('pt_BR');
    }

    protected function _initCache() {
        $frontendOptions = array('lifetime' => null, 'automatic_serialization' => true);
        $backendOptions = array();
        $coreCache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        Zend_Db_Table_Abstract::setDefaultMetadataCache($coreCache);
        Zend_Registry::set('cache', $coreCache);
    }

    protected function _initPlugins() {
        $bootstrap = $this->getApplication();
        if ($bootstrap instanceof Zend_Application) :
            $bootstrap = $this;
        endif;
        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource('FrontController');

        /* Plugin do Layout */
        $front->registerPlugin(new WS_Plugins_Layout());

        /* Plugin de erro */
        $front->registerPlugin(new WS_ErrorControllerSelector());

    }

    protected function _initRotes() {
        $modulo = 'default';
        $this->controller = Zend_Controller_Front::getInstance();
        $this->router = $this->controller->getRouter();
        $this->router->addRoute('default', new Zend_Controller_Router_Route('/:controller/:action', array(
                    'controller' => 'index',
                    'action' => 'index',
                    'module' => $modulo
                )));
    }

}