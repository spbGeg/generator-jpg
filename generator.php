<?php
require_once ('db/db_connect.php');
if (isset($_GET['name']) & isset($_GET['size'])) {
    $name = htmlspecialchars($_GET["name"]);
    $size = htmlspecialchars($_GET["size"]);
    //connect to db take all type size
    $allTypeSize = $stm->fetchAll();



    //start resizing

    if(isset($_GET['all'])){ // resize all image fore demonstrate gallery
        foreach($allTypeSize as $size_item){
            $size = $size_item['size_type'];
            resizeImage($name, $size);

        }
    }else  resizeImage($name, $size);
} else {

    exit("<h1>Измененить размер картинки не удалось обратитесь к администратору</h1>");
}



function resizeImage($name, $size)
{
    global $allTypeSize;



    foreach ($allTypeSize as $size_item) {
        if ($size_item['size_type'] == $size) {
            $w = $size_item['width'];
            $h = $size_item['height'];
        }
    }


    $name = $name . '.jpg';
    $filename = __DIR__ . '/gallery/' . $name;
    $resize_image = __DIR__ . '/cache/resize_' . $w . 'x' . $h . '_' . $name;
//check true existing file
    if (!file_exists($filename)) {
        exit('такого файла не существует');
    }

//check converted file with given size

    if (file_exists($resize_image)) {
        //return "<img  src='/cache/resize_150x150_". $resize_image .".jpg' alt=''>";
        echo "<img  src='/cache/resize_150x150_". $name ."'  alt=''>";
        exit;
//exit('Файл уже преобразован и лежит в папке cache');
    }
// size new image.

    $info = getimagesize($filename);
    $width = $info[0];
    $height = $info[1];
    $type = $info[2];



    switch ($type) {
        case 1:
            $img = imageCreateFromGif($filename);
            imageSaveAlpha($img, true);
            break;
        case 2:
            $img = imageCreateFromJpeg($filename);
            break;
        case 3:
            $img = imageCreateFromPng($filename);
            imageSaveAlpha($img, true);
            break;
    }


    if (empty($w)) {
        $w = ceil($h / ($height / $width));
    }
    if (empty($h)) {
        $h = ceil($w / ($width / $height));
    }

    $tmp = imageCreateTrueColor($w, $h);

//fill white background of the picture
    imagealphablending($tmp, true);
    imageSaveAlpha($tmp, true);
    $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
    imagefill($tmp, 0, 0, $transparent);
    imagecolortransparent($tmp, $transparent);


    $tw = ceil($h / ($height / $width));
    $th = ceil($w / ($width / $height));
    if ($tw < $w) {
        imageCopyResampled($tmp, $img, ceil(($w - $tw) / 2), 0, 0, 0, $tw, $h, $width, $height);
    } else {
        imageCopyResampled($tmp, $img, 0, ceil(($h - $th) / 2), 0, 0, $w, $th, $width, $height);
    }

    $img = $tmp;


    switch ($type) {
        case 1:
            imageGif($img, $resize_image);
            break;
        case 2:
            imageJpeg($img, $resize_image, 100);
            break;
        case 3:
            imagePng($img, $resize_image);
            break;
    }


    imagedestroy($img);
//return "<img  src='/cache/resize_150x150_". $resize_image .".jpg' alt=''>";


    echo "<img  src='/cache/resize_150x150_". $name ."'  alt=''>";
}




?>

