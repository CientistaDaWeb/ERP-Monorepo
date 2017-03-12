<?php

class WS_LiveDocx_Model extends Zend_Service_LiveDocx_MailMerge {

    public function __construct($options = null) {
        parent::__construct($options);

        $application = Zend_Registry::get('application');
        $this->setUsername($application->service->livedocx->username)
                ->setPassword($application->service->livedocx->password);
    }

}
