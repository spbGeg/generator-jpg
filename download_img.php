<?php
$uploaddir = 'gallery/';
// это папка, в которую будет загружаться картинка
$apend = date('YmdHis') . rand(100, 1000) . '.jpg';
// это имя, которое будет присвоенно изображению
$uploadfile = "$uploaddir$apend";
//в переменную $uploadfile будет входить папка и имя изображения

// В данной строке самое важное - проверяем загружается ли изображение (а может вредоносный код?)
// И проходит ли изображение по весу. В нашем случае до 1Mb
if ($_FILES['userfile']['type'] == 'image/jpeg') {
    if ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size'] <= 1000000) {
        // Указываем максимальный вес загружаемого файла. Сейчас до 1Mb
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            //Здесь идет процесс загрузки изображения
            $size = getimagesize($uploadfile);
            // с помощью этой функции мы можем получить размер пикселей изображения
            if ($size[0] < 1601 && $size[1] < 1601) {
                // если размер изображения не более 1600 пикселей по ширине и не более 1600 по  высоте
                //echo "Файл загружен. </b>";
                echo '<meta http-equiv="refresh" content="0;URL=/demo.php?file-download=success">';
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=/demo.php?file-download=too-big-size">';
                unlink($uploadfile);
                // удаление файла
            }
        } else  echo '<meta http-equiv="refresh" content="0;URL=/demo.php?file-download=too-big-size">';
    } else  echo '<meta http-equiv="refresh" content="0;URL=/demo.php?file-download=too-big-size">';

} else  echo '<meta http-equiv="refresh" content="0;URL=/demo.php?file-download=format-no-valid">';


?>