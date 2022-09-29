<?php

class WS_File {

    public function create($arquivo, $content, $lower = 'false') {
        $content[] = '';
        $fp = fopen($arquivo, 'w');
        $content = implode("\n", $content);
        if ($lower):
            strtolower($content);
        endif;
        fwrite($fp, $content);
        fclose($fp);
    }

    public function remove($file) {
        unlink($file);
    }

    function create_zip($files = array(), $destination = '', $overwrite = false) {
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        $valid_files = array();
        if (is_array($files)) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        if (count($valid_files)) {
            $zip = new ZipArchive();
            if ($zip->open($destination, ZIPARCHIVE::OVERWRITE | ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            foreach ($valid_files as $file) {
                $nome = explode('/', $file);
                $tot = count($nome);
                $zip->addFile($file, $nome[$tot - 1]);
            }
            $zip->close();
            return file_exists($destination);
        } else {
            return false;

        }
    }

    public function read($arquivo) {
        $retorno = '';
        $ponteiro = fopen($arquivo, "r");
        while (!feof($ponteiro)) {
            $linha = fgets($ponteiro, 4096);
            $retorno[] = $linha;
        }
        fclose($ponteiro);
        return $retorno;
    }

}
