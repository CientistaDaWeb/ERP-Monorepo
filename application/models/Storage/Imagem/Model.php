<?php

class Storage_Imagem_Model {

    public function buscaImagem($data) {
        $parametros = $data;
        $params = array(
            'w' => '150', // largura
            'h' => '150', // altura
            'c' => 'false', // crop
            'b' => 'transparent', // background
        );
        if ($params['w'] > 1000) :
            $params['w'] = 1000;
        endif;
        if ($params['h'] > 1000) :
            $params['h'] = 1000;
        endif;
        foreach ($parametros AS $key => $value) {
            $params[$key] = $value;
        }

        $imagem = APPLICATION_PATH . '/../public/uploads/' . $data['folder'] . '/' . $data['file'];
        if (!is_file($imagem)):
            $data['folder'] = 'default';
            $data['file'] = 'notfound.jpg';
        endif;

        $partida = UPLOAD_PATH . $data['folder'] . '/';
        $destino = UPLOAD_PATH . 'resized/' . $data['folder'] . '/';

        $image = explode('.', $data['file']);
        $imageName = $image[0] . '_' . $params['w'] . '_' . $params['h'] . '_' . $params['c'] . '_' . $params['b'];
        $imagem = $destino . $imageName . '.' . $image[1];

        if (!is_file($imagem)):
            $upload = new Upload($partida . $data['file']);
            if ($upload->uploaded):
                $upload->image_resize = true;

                if ($params['w'] != 'auto'):
                    $upload->image_x = $params['w'];
                else:
                    $upload->image_ratio_x = true;
                endif;

                if ($params['h'] != 'auto'):
                    $upload->image_y = $params['h'];
                else:
                    $upload->image_ratio_y = true;
                endif;

                if ($params['c'] == 'crop'):
                    $upload->image_ratio_crop = true;
                else:
                    $upload->image_ratio_fill = true;
                endif;
                if ($params['b'] != 'transparent'):
                    $upload->image_background_color = '#' . $params['b'];
                endif;

                $upload->file_auto_rename = false;
                $upload->file_new_name_body = $imageName;
                $upload->process($destino);
                if ($upload->processed) :
                    $imagem = $upload->file_dst_pathname;
                else:
                    echo $upload->error;
                    exit();
                endif;
            endif;
        endif;

        header('Content-Type: image');
        readfile($imagem);
    }

}