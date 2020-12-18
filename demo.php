<?
require_once('db/db_connect.php');
//connect to db take all type size
//get all type size
$allTypeSize = $stm->fetchAll();
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

		<h3 class="generator-preview__title">Кликните на картинку для демострации</h3>


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

				</div>

				<script>
                    var nameImage = "<?=$previewImage?>";
                    var sizeImage = "mic";
                    $.ajax({
                        url: 'generator.php',         /* Куда пойдет запрос */
                        method: 'get',             /* Метод передачи (post или get) */
                        dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
                        data: {
                            name: nameImage,
                            size: sizeImage
                        },     /* Параметры передаваемые в запросе. */
                        success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
                            $("#preview_image_<?=$previewImage?>").html(data);            /* В переменной data содержится ответ от generator.php */
                        }
                    });
				</script>

            <? } ?>

		</div>

		<div class="row ">
			<div id="gallery" class="col-12 gallery">
				<span class="close"><img src="img/close.png" alt=""></span>
				<div id="panel">


					<img id="largeImage" src="images/sample_a.jpg" alt="150x150"/>
					<div id="description"></div>
				</div>
				<div id="thumbs">
                    <?
                    //add img == count type size
                    for ($i = 0; $i < $count_size; $i++) {
                        ?>
						<img class="thumb__image" src=""
						     alt="<?= $allTypeSize[$i]['width']; ?>x<?= $allTypeSize[$i]['height']; ?>" title="">
                    <? } ?>
				</div>


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

				<a href="#">
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
         $('#description').html($(this).attr('alt'));
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
        $("#largeImage").attr('src', srcLargeImage);

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
            }
            });


        // var nameImage = $(this).children("img").attr("title");
        // //generate first LargeImage
        // var sizeImage = "mic";
        // $.ajax({
        //     url: 'generator.php',         /* Куда пойдет запрос */
        //     method: 'get',             /* Метод передачи (post или get) */
        //     dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
        //     data: {
        //         name: nameImage,
        //         size: sizeImage
        //     },     /* Параметры передаваемые в запросе. */
        //     success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
        //         $("#largeImage").(data);            /* В переменной data содержится ответ от generator.php */
        //     }
        // });
        //
        //
        // alert(name);
        //$('#largeImage').attr('src',$(this).attr('src'));


        gallery.fadeIn();

        $('.close').click(function () {
            gallery.fadeOut();
        });

        thumbImage.click(function () {

            $('#description').text($(this).attr('alt'));
        });


    });


</script>

<script>
    // var allTypeSize = new Array();
    // var i = 0;
    // allTypeSize[i]['size_type'] = "Это мой размер"
    <!--    --><?//for($i = 0; $i < count($allTypeSize); $i++){?>
    //
    //    allTypeSize[i]['size_type'] = "<?//=$allTypeSize['size_type'];?>//";
    //    allTypeSize[i]['width'] = "<?//=$allTypeSize['width'];?>//";
    //    allTypeSize[i]['height'] = "<?//=$allTypeSize['height'];?>//";
    //    i++;
    //    <?//}?>
    //     alert(allTypeSize);
</script>
</body>
</html>