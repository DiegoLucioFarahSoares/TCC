<?php

$sicPath = '/view/pages';

header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . "/../../app/src/classes/modules/config/ConnectionPDO.php";

?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/snippets/header.php"; ?>
</head>

<body>
<?php include __DIR__ . "/snippets/login/esqueci-senha.php"; ?>
<?php include __DIR__ . "/snippets/script.php"; ?>

<script src="/node_modules/jquery-validation/dist/jquery.validate.js"></script>
<script src="/node_modules/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.js"></script>

<script src="/view/pages/assets/js/genericService.js"></script>
<script src="/view/pages/snippets/login/assets/js/esqueci-senha.js"></script>

<script type="text/javascript">
    var generic = new GenericService();
    generic.Login = new EsqueciSenha();
</script>
</body>

</html>