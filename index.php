<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="lib/bootstrap/css/bootstrap-grid.css">
	<link rel="stylesheet" href="css/main.css">
	<title>Generator jpg</title>
</head>
<body class="index-page">
<div class="container content">
	<div class="row">
		<div class="col-12 center">
			<div class="text">
				<h1>Протестируйте приложение автоматически изменяющее размер картинки в формате .jpg</h1>
				<a href="demo.php">
					<div class="button">Протестировать решение</div>
				</a>

				<div class="bg-img"></div>

				<p><strong>1 - Генератор изображений - </strong>generator.php</p>
				<ul>
					<li>Исходники картинок хранятся в папке gallery.</li>
					<li>Get-параметры: name(название картинки без расширения) и size(код размера).</li>
					<li>Список размеров для генерации хранится в MySql:
						<ul>
							<li>"big" - 800 * 600, "med" - 640 * 480,&nbsp; "min" - 320 * 240,&nbsp; "mic" - 150 * 150
							</li>
						</ul>
					</li>
					<li>Указаны максимальные размеры сторон, при масштабировании пропорции сохраняются.</li>
					<li>Результат работы скрипта &ndash; jpg-картинка заданного размера.</li>
					<li>Сгенерированное изображение сохраняется в папке cache. Если есть кеш, повторно не генерируем.
					</li>
				</ul>
				<p><strong>2 - Галерея </strong>&ndash; demo.php</p>
				<ul>
					<li>SRC картинок указывает на generator.php(с нужными параметрами).</li>
					<li>Для демонстрации работы генератора, плиткой выводим 10 превью-картинок.
						<ul>
							<li>Превью &ndash; картинка в минимальном размере, в зависимости типа от устройства.</li>
						</ul>
					</li>
					<li>При клике на превью, на той же странице открывается любая jquery галерея. В ней можно увидеть
						картинку во всех допустимых для устройства размерах.
					</li>
					<li>Ограничения для устройств:
						<ul>
							<li>Мобильные устройства &ndash; не выводятся big картинки</li>
							<li>Desktop &ndash; не выводятся mic картинки</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>


</body>
</html>