<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="jquery.lightbox.css">
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

            <? foreach ($arrImage as $previewImage) { ?>
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
                            $("#preview_image-link_<?=$previewImage?>").html(data);            /* В переменной data содержится ответ от generator.php */
                        }
                    });
				</script>

				<div id=#preview_image_<?= $previewImage ?>" class="generator-preview__image col-lg-2 col-md-3 col-6">
					<a href="#" id="preview_image-link_<?= $previewImage ?>">

					</a>
				</div>
            <? } ?>

		</div>

		<div class="row gallery">
			<div class="col-12">

			</div>

		</div>
	</div>

	<footer class="container footer">
		<div class="row">
			<div class="col-6 copyright align-middle">

				Copyright © 2020 Romanov Vadim<br>

				Создано на Native PHP</a>.

			</div>

			<div class="col-6 github">

				<a href="#">
					Github<img src="/img/github.png" alt="Github">
				</a>


			</div>


		</div>
	</footer>


	<div class="footer container">
		<div class="row">


		</div>
	</div>
</div>
</body>
</html>