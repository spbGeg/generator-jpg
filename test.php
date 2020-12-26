<?
// ... формируем путь к картинке $fileLocation
if (isset($_GET['name']) & isset($_GET['size'])) {
    $name = htmlspecialchars($_GET["name"]);
    $size = htmlspecialchars($_GET["size"]);
//address image
    $fileLocation = 'gallery/' . $name . ".jpg";
    header("Content-Type: image/png");
//add header with cache
    header("Cache-Control: max-age=86400");
    header("Pragma: cache");
    header("Expires: " . date(DATE_RFC2822, time() + 86400));

    $fileHeader = fopen($fileLocation, 'r', false);
    $response = "img/no-image.png";  //return default img if__ img not found from request

    if ($fileHeader) {
        $response = stream_get_contents($fileHeader);
        fclose($fileHeader);
    }

    exit($response);
}


?>