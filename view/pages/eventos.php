<?php

$sicPath = '/view/pages';

header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . "/verifica.php";
?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/snippets/header.php"; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link rel="stylesheet" href="<?php print $sicPath; ?>/assets/css/calendario/calendario.css">
</head>

<body>
<?php include __DIR__ . "/snippets/sidenav.php"; ?>
<?php include __DIR__ . "/snippets/eventos/main.php"; ?>
<?php include __DIR__ . "/snippets/script.php"; ?>

<!--<script src="/node_modules/moment/moment.js"></script>-->
<!--<script src='/node_modules/fullcalendar/main.js'></script>-->
<script src='node_modules/fullcalendar/locales/pt-br.js'></script>
<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>
<script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='<?php print $sicPath; ?>/assets/js/components/calendario.js'></script>

</body>

</html>