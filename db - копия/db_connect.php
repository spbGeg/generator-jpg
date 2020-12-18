<?

$dbh = new \PDO('mysql:host=localhost;dbname=generator_image;', 'root', '');
$dbh->exec('SET NAMES UTF8');
$stm = $dbh->prepare('SELECT * FROM `size`');
$stm->execute();