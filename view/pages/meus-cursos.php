<?php

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\repository\sicCursosRepository;

$sicPath = '/view/pages';

header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . "/verifica.php";

$conn = ConnectionPdo::getConnection();
$repository = new sicCursosRepository($conn);

$retorno = $repository->consultar('');

?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/snippets/header.php"; ?>
</head>

<body>
<?php include __DIR__ . "/snippets/sidenav.php"; ?>
<?php include __DIR__ . "/snippets/cursos/meus-cursos/main.php"; ?>
<?php include __DIR__ . "/snippets/script.php"; ?>
</body>

</html>