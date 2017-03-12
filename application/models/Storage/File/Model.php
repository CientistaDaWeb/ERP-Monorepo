<?php

class Storage_File_Model {

    public function buscaFile($data) {
        $parametros = $data;

        $file = UPLOAD_PATH . $data['folder'] . '/' . $data['file'];

        if (is_file($file)):
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file);
            header('Content-Type: ' . $mime);
            header('Content-Length: ' . filesize($file));
            if ($data['mode'] == 'save'):
                header('Content-Disposition: attachment; filename=' . basename($file));
            endif;
            readfile($file);
        else:
            echo 'Arquivo não encontrado';
        endif;
    }

}