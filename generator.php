<?php
require_once ('db/db_connect.php');
if (isset($_GET['name']) & isset($_GET['size'])) {
    $name = htmlspecialchars($_GET["name"]);
    $size = htmlspecialchars($_GET["size"]);
    //connect to db take all type size
    $allTypeSize = $stm->fetchAll();

////address image
//    $fileLocation = 'gallery/' . $name . ".jpg";
//    header("Content-Type: image/jpg");
////add header with cache
//    header("Cache-Control: max-age=86400");
//    header("Pragma: cache");
//    header("Expires: " . date(DATE_RFC2822, time() + 86400));
//
//    $fileHeader = fopen($fileLocation, 'r', false);
//    $response = "img/no-image.png";  //return default img if__ img not found from request
//
//    if ($fileHeader) {
//        $response = stream_get_contents($fileHeader);
//        fclose($fileHeader);
//    }
//
//    exit($response);


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


    $full_name = $name . '.jpg';
    $filename = __DIR__ . '/gallery/' . $full_name;
    $resize_image = __DIR__ . '/cache/resize_' . $w . 'x' . $h . '_' . $full_name;
//check true existing file
    if (!file_exists($filename)) {
        exit('такого файла не существует');
    }

//check file already converted with given size

    if (file_exists($resize_image)) {
        fpassthru($resize_image);
        //return "<img  src='/cache/resize_" .$w . "x" . $h."_" . $full_name ."'  alt='" . $w . "x" . $h ."' title='".$name."'>";
        //echo "<img  src='/cache/resize_" .$w . "x" . $h."_" . $full_name ."'  alt='" . $w . "x" . $h ."' title='".$name."'>";
        exit;
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
//return "<img  src='/cache/resize_" .$w . "x" . $h."_" . $full_name ."'  alt='" . $w . "x" . $h ."' title='".$name."'>";


    //echo "<img  src='/cache/resize_" .$w . "x" . $h."_" . $full_name ."'  alt='" . $w . "x" . $h ."' title='".$name."'>";
}




?>

