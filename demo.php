<?
require_once('db/db_connect.php');

//indentify device
function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

if (isMobile()) $device = "mobile";

//get download file status
if (isset($_GET['file-download'])) {
    $file_download = $_GET['file-download'];

    switch ($file_download) {
        case "success":
            $file_download = "Файл загружен";
            break;
        case "too-big-size":
            $file_download = "Превышен допустимый размер файла";;
            break;
        case "format-no-valid":
            $file_download = "Формат изображения не jpg! Загрузите нужный формат";;
            break;
        default:
            $file_download = "Не удалось загрузить изображение";
            break;

    }

}

//connect to db take all type size
//get all type size
$allTypeSize = $stm->fetchAll();


//delete img with size big for mobile device or size bic for desktop
if ($device == 'mobile') {
    for ($i = 0; $i < count($allTypeSize); $i++) {
        if ($allTypeSize[$i]['size_type'] == 'big') unset($allTypeSize[$i]);
    }
    sort($allTypeSize);

} else {
    for ($i = 0; $i < count($allTypeSize); $i++) {
        if ($allTypeSize[$i]['size_type'] == 'mic') unset($allTypeSize[$i]);
    }
    sort($allTypeSize);
}

//var_dump($allTypeSize);
$count_size = count($allTypeSize);


?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="lib/jquery/css/jquery.lightbox.min.css">
	<link rel="stylesheet" href="lib/bootstrap/css/bootstrap-grid.css">
	<link rel="stylesheet" href="/css/main.css">
	<script src="lib/jquery/js/jquery-3.4.1.js"></script>


	<title>Демонстрация работы генератора jpg</title>
</head>
<body>

<div class="wrappage ">

	<div class="header container">
		<div class="row">
			<div class="col-12">
				<h1 class="main-title">Демонстрация генератора jpg</h1>

			</div>
		</div>

	</div>
	<div class="content container ">

		<h3 class="generator-preview__title">Нажмите на картинку для демострации и генерации ее в разных размерах</h3>
        <? // var_dump($allTypeSize) ?>

		<div class="row generator-preview">
            <?
            // take all files in a gallery
            $gallery = 'gallery';
            $arrImage = scandir($gallery);
            array_shift($arrImage); // delete in array '.'
            array_shift($arrImage); //  delete in array '..'
            for ($i = 0; $i < count($arrImage); $i++) {
                //take name file
                $arrImage[$i] = preg_replace('/\.\jpg+$/', '', $arrImage[$i]);
            }

            ?>
			<!--add all preview image -->
            <? foreach ($arrImage as $previewImage) { ?>
				<div id="preview_image_<?= $previewImage ?>" class="generator-preview__image col-lg-2 col-md-3 col-6">
					<img src="test.php?name=<?=$previewImage?>&size=mic" title="<?=$previewImage?>">
				</div>



            <? } ?>

		</div>

		<div class="row ">
			<div id="gallery" class="col-12 gallery">
				<span class="close"><img src="img/close.png" alt=""></span>
				<div id="panel">


					<img id="largeImage" src="img/loading.gif" alt="Выберите картинку с нужным размером"/>
					<div id="description"></div>
				</div>
				<div id="thumbs">
                    <?
                    //add img == count type size
                    for ($i = 0; $i < $count_size; $i++) { ?>

						<img class="thumb__image" src="img/no_image.png"
						     alt="<?= $allTypeSize[$i]['width']; ?>x<?= $allTypeSize[$i]['height']; ?>" title="">
                    <? } ?>
				</div>


			</div>

		</div>


		<div class="row add-img">
			<div class="col-12 add-img__form">
				<span class="add-img__title">Размер изображения не должен превышать 1Mb, размеры по ширине не более 1600px, по высоте не более 1600px.</span>
				<form name="upload" action="download_img.php" method="POST" ENCTYPE="multipart/form-data">
					<div class="form-group">
						<span>Выберите файл для загрузки:</span>
						<span class="alert" <?if($file_download == "success")echo"style='color: #1ab918'";?>><?=$file_download?></span>

						<input type="file" name="userfile">
						<input type="submit" name="upload" value="Загрузить">
					</div>

				</form>
			</div>
		</div>
	</div>

	<footer class="container footer">
		<div class="row">
			<div class="col-6 copyright align-middle">

				Copyright © 2020 Romanov Vadim<br>

				Создано на Native PHP.

			</div>

			<div class="col-6 github">

				<a href="https://github.com/spbGeg/generator-jpg.git">
					Github<img src="/img/github.png" alt="Github">
				</a>


			</div>


		</div>
	</footer>


</div>

<script>
    var thumbImage = $('.thumb__image');
    var gallery = $('.gallery');
    $('#thumbs').delegate('img', 'click', function () {
        $('#largeImage').attr('src', $(this).attr('src').replace('thumb', 'large'));
        //$('#description').html($(this).attr('alt'));
    });
    //add descrition image
    $('#description').text($('#largeImage').attr('alt'));
    gallery.hide();

    //show gallery
    $('.generator-preview__image').click(function () {


        var srcLargeImage = $(this).children("img").attr("src");
        var sizeDemention;
        var handleImageName = $(this).children("img").attr("title");

        //change src attr largeImage gallery
        //$("#largeImage").attr('src', srcLargeImage);

        //create all size handle image
        $.ajax({
            url: 'generator.php',         /* Куда пойдет запрос */
            method: 'get',             /* Метод передачи (post или get) */
            dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
            data: {
                name: handleImageName,
                size: 'mic',
                all: 1,

            },
            success: function () {
                //change all attr "src" and "title" in all thumbs img
                thumbImage.each(function () {
                    sizeDemention = $(this).attr("alt");

                    $(this).attr('src', 'cache/resize_' + sizeDemention + '_' + handleImageName + '.jpg');
                    $(this).attr('title', handleImageName);

                });
                //change src attr largeImage gallery
                //alert($('#thumbs').children(':first').attr('src'))
                $("#largeImage").attr('src', $('#thumbs').children(':first').attr('src'));
            }
        });

        gallery.fadeIn();

        $('.close').click(function () {
            gallery.fadeOut();
        });

        thumbImage.click(function () {

            $('#description').text($(this).attr('alt'));
        });


    });


</script>


</body>
</html>