<?php
/**
 * Created by PhpStorm.
 * User: market7
 * Date: 16.12.2020
 * Time: 10:55
 */

class ResizeImage
{

    public function resizeImage($filename, $max_width, $max_height)
    {
        list($orig_width, $orig_height,,,,,$mime) = getimagesize($filename);
        $wert = getimagesize($filename);

        $width = $orig_width;
        $height = $orig_height;

        # taller
        if ($height > $max_height) {
            $width = ($max_height / $height) * $width;
            $height = $max_height;
        }

        # wider
        if ($width > $max_width) {
            $height = ($max_width / $width) * $height;
            $width = $max_width;
        }
        //создаем картинку под размеры
        $image_p = imagecreatetruecolor($width, $height);

        //В зависимости от расширения картинки вызываем соответствующую функцию
        if ($wert['mime'] == 'image/png') {
            $src = imagecreatefrompng($filename); //создаём новое изображение из файла
        } else if ($wert['mime'] == 'image/jpeg') {
            $src = imagecreatefromjpeg($filename);
        } else if ($wert['mime'] == 'image/gif') {
            $src = imagecreatefromgif($filename);
        } else {
            return false;
        }

        //сохраняем прозрачность
        imageAlphaBlending($image_p, false);
        imageSaveAlpha($image_p, true);
        imagecopyresampled($image_p, $src, 0, 0, 0, 0,
            $width, $height, $orig_width, $orig_height);

        return $image_p;
        //$filename = 'resize-' . $filename;
       // return imagepng($image_p, $filename);//Сохраняет JPEG/PNG/GIF изображение
    }

}