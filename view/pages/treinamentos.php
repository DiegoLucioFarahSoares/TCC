<?php

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\repository\sicTreinamentosRepository;

$sicPath = '/view/pages';

header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . "/verifica.php";

$conn = ConnectionPdo::getConnection();
$repository = new sicTreinamentosrepository($conn);

$retorno = $repository->consultar('');

?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/snippets/header.php"; ?>
</head>

<body>
<?php include __DIR__ . "/snippets/sidenav.php"; ?>
<?php include __DIR__ . "/snippets/treinamentos/meus-treinamentos/main.php"; ?>
<?php include __DIR__ . "/snippets/script.php"; ?>
</body>

</html>