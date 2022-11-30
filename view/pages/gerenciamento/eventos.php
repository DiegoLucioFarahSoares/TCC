<?php

$sicPath = '/view/pages';

header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . "/../verifica.php";

?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/../snippets/header.php"; ?>
</head>

<body>
<?php include __DIR__ . "/../snippets/sidenav.php"; ?>
<?php include __DIR__ . "/../snippets/gerenciamento/eventos/main.php"; ?>
<?php include __DIR__ . "/../snippets/script.php"; ?>

<script src="/node_modules/jquery-validation/dist/jquery.validate.js"></script>
<script src="/node_modules/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.js"></script>

<script src="<?php print $sicPath; ?>/assets/js/genericService.js"></script>
<script src="<?php print $sicPath; ?>/snippets/gerenciamento/eventos/assets/js/eventos.js?v=<?= time() ?>"></script>

<script type="text/javascript">
    var generic = new GenericService();
    generic.Eventos = new Eventos();
    generic.Eventos.init();
</script>
</body>

</html>