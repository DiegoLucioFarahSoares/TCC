<?php

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\repository\sicCursosRepository;
use app\src\classes\modules\repository\sicMidiasRepository;

$sicPath = '/view/pages';

header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . "/verifica.php";

$conn = ConnectionPdo::getConnection();
$repository = new sicCursosRepository($conn);
$repositoryMidias = new sicMidiasRepository($conn);

$params['idCursos'] = $_GET['cod'];

$retorno = $repository->consultar($params);
$retornoMaisCursos = $repository->consultar('');
$retornoMidias = $repositoryMidias->consultar($params);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/snippets/header.php"; ?>
</head>

<body>
<?php include __DIR__ . "/snippets/sidenav.php"; ?>
<?php include __DIR__ . "/snippets/cursos/meus-cursos/detalhes.php"; ?>
<?php include __DIR__ . "/snippets/script.php"; ?>

<script src="<?php print $sicPath; ?>/snippets/cursos/meus-cursos/assets/js/detalhes.js?v=<?= time() ?>"></script>
</body>

</html>