<?php

$sicPath = '/view/pages';

header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . "/verifica.php";

?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/snippets/header.php"; ?>
</head>

<body>
<?php include __DIR__ . "/snippets/sidenav.php"; ?>
<?php include __DIR__ . "/snippets/meu-perfil/main.php"; ?>
<?php include __DIR__ . "/snippets/script.php"; ?>

<script src="/node_modules/jquery-validation/dist/jquery.validate.js"></script>
<script src="/node_modules/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.js"></script>
<script src="/node_modules/jquery-mask-plugin/src/jquery.mask.js"></script>

<script src="<?php print $sicPath; ?>/assets/js/settings.js"></script>
<script src="<?php print $sicPath; ?>/assets/js/genericService.js"></script>
<script src="<?php print $sicPath; ?>/snippets/meu-perfil/assets/js/meu-perfil.js?v=<?= time() ?>"></script>
<script src="<?php print $sicPath; ?>/assets/js/eEstados.js"></script>

<script type="text/javascript">
    var generic = new GenericService();
    generic.MeuPerfil = new MeuPerfil();
    generic.MeuPerfil.init();
</script>
</body>

</html>