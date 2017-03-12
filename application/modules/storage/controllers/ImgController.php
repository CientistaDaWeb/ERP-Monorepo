<?php

class Storage_ImgController extends Zend_Controller_Action {

    protected $_processor;
    protected $_cache;

    public function init() {
        parent::init();

        $this->_processor = new Resizer();
        $this->_cache = $this->_initCache();
    }

    private function _initCache() {
        $frontendOptions = array(
            'lifeTime' => 0
        );
        $backendOptions = array(
            'cache_dir' => UPLOAD_PATH . '/cache'
        );
        return Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
    }

    public function indexAction() {

        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $w = (int) $this->_getParam('w');
        $h = (int) $this->_getParam('h');
        $q = (int) $this->_getParam('q');
        $b = $this->_getParam('b');
        $filename = $this->_getParam('file');
        $path = $this->_getParam('folder');
        $crop = $this->_getParam('c');
        $format = substr($filename, -3);

        $request_modified = '';
        if ($mod_since = $this->getRequest()->getHeader('If-Modified-Since')) {
            $request_modified = explode(';', $mod_since);
            $request_modified = strtotime($request_modified[0]);
        }

        if ($this->getFiletime($path, $filename) > 0 && $this->getFiletime($path, $filename) <= $request_modified) {
            header('HTTP/1.1 304 Not Modified');
            exit;
        } else {
            $cache_id = str_replace('.', '', WS_Text::slug($path, '_') . '_' . $filename . '_' . $w . '_' . $h . '_' . $b . '_' . $q . '_' . $crop . '_' . $format);


            if (!$imagedata = $this->_cache->load($cache_id)) {
                $imagedata = $this->_processor->processImage($path, $filename, $w, $h, $crop, $format, $b, $q);
                $this->_cache->save($imagedata, $cache_id, array('image', WS_Text::slug($path, '_') . '_' . str_replace('.', '', $filename)));

            }

            $mimetype = $this->getMIMEType($path, $filename);
            $format = substr(strstr($mimetype, '/'), 1);
            $this->getResponse()->setHeader('Content-type', $mimetype);
            $expires = 60 * 60 * 24 * 14;
            $exp_gmt = gmdate('D, d M Y H:i:s', time() + $expires) . 'GMT';
            $mod_gmt = gmdate('D, d M Y H:i:s', $this->getFiletime($path, $filename)) . 'GMT';

            // Send Headers for Browser Caching Control
            $this->getResponse()->setHeader('Expires', $exp_gmt, true);
            $this->getResponse()->setHeader('Last-Modified', $mod_gmt, true);
            $this->getResponse()->setHeader('Cache-Control', 'public, max-age=' . $expires, true);
            $this->getResponse()->setHeader('Pragma', '!invalid', true);
            $this->getResponse()->setHeader('Content-Length', strlen($imagedata), true);
            $this->getResponse()->setHeader('ETag', md5($imagedata), true);
            echo $imagedata;
        }
    }

    public function hiresAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $filename = $this->_getParam('filename');
        $path = split('_', $this->_getParam('path'));
        $mimetype = $this->getMIMEType($path[0] . '_' . $path[1], $filename);
        $format = substr(strstr($mimetype, '/'), 1);
        header('Content-type: ' . $mimetype);
        header('Content-Disposition: attachment; filename=' . $filename . '.' . $format);
        readfile(UPLOAD_PATH . '/' . $path[1] . '/' . $filename);
    }

    private function getMIMEType($path, $filename) {
        $imgsize = getimagesize(UPLOAD_PATH . str_replace('_', '/', $path) . '/' . $filename);
        return $imgsize['mime'];
    }

    private function getFiletime($path, $filename) {
        $time = filemtime(UPLOAD_PATH . str_replace('_', '/', $path) . '/' . $filename);
        return $time;
    }

}
