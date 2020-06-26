<?php

class WS_Folder {

    public function remove($path) {
        if (!is_dir($path)) {
            return false;
        }
        if (!preg_match("/\\/$/", $path)) {
            $path .= '/';
        }
        chmod($path, 0777);
        self::create($path);
        $dh = opendir($path);

        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($path . $file)) {
                chmod($path, 0777);
                mkdir($path, 0777, true);
                $this->remove($path . $file);
            } else if (is_file($path . $file)) {
                chmod($path . $file, 0777);
                unlink($path . $file);
            }
        }
        closedir($dh);
        rmdir($path);
        return true;
    }

    public function create($path) {
        if (!is_dir($path)):
            mkdir($path);
        endif;
    }

    public function read($path, $return = NULL) {
        if (!is_dir($path)) {
            return false;
        }
        if (!preg_match("/\\/$/", $path)) {
            $path .= '/';
        }

        $dh = opendir($path);

        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($path . $file)) {
                $this->read($path . $file, $return);
            } else if (is_file($path . $file)) {
                $retorno['path'] = $path;
                $retorno['file'] = $file;
                $retorno['real_path'] = $path . $file;
                $return[] = $retorno;
            }
        }
        if (isset($return)):
            return $return;
        endif;
    }

}
