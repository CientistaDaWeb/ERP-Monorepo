<?php

class Resizer {

    public function processImage($path, $filename, $x, $y, $crop = 'crop', $format = 'jpg', $background = null, $q = 90) {
        if ($q < 40):
            $q = 50;
        endif;
        $filename = UPLOAD_PATH . str_replace('_', '/', $path) . '/' . $filename;
        if (file_exists($filename)) {
            $handle = new Upload($filename);
            $handle->image_resize = true;
            $handle->jpeg_quality = $q;

            if ($x != 'auto'):
                $handle->image_x = $x;
            else:
                $handle->image_ratio_x = true;
            endif;

            if ($y != 'auto'):
                $handle->image_y = $y;
            else:
                $handle->image_ratio_y = true;
            endif;

            if ($crop == 'crop'):
                $handle->image_ratio_crop = true;
            else:
                $handle->image_ratio_fill = true;
            endif;

            if ($background):
                $handle->image_background_color = '#' . $background;
            endif;

            if ($processed = $handle->process()) {
                return $processed;
            } else {
                throw new Zend_Exception('Error processing Image: ' . $handle->error . '(trying to process ' . $filename . ')!'
                );
            }
        } else {
            $filename = UPLOAD_PATH . 'default/default.jpg';
            $handle = new Upload($filename);
            $handle->image_resize = true;
            $handle->image_x = $x;
            $handle->image_y = $y;
            $handle->image_ratio_fill = true;
            if ($processed = $handle->process()) {
                return $processed;
            } else {
                throw new Zend_Exception('Error processing Image: ' . $handle->error . '(trying to process ' . $filename . ')!'
                );
            }
        }
    }

}
