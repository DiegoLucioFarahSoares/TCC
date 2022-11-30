<?php

$sicPath = '/view/pages';

header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . "/../../../app/src/classes/modules/config/ConnectionPDO.php";

?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/../snippets/header.php"; ?>
</head>

<body class="error-page">

<main class="main-content mt-0">
    <div class="page-header min-vh-100" style="background-image: url('<?php print $sicPath; ?>/assets/img/error.svg');
         padding: 0;
         position: relative;
         overflow: hidden;
         display: flex;
         align-items: center;
         background-size: cover;
         background-position: 50%;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-7 mx-auto text-center">
                    <h1 class="display-1 text-bolder text-primary">Error 500</h1>
                    <h2>Algo deu errado.</h2>
                    <p class="lead">Sugerimos que você vá para a página inicial enquanto resolvemos este problema.</p>
                    <button type="button" class="btn bg-gradient-dark mt-4">Vá para a página inicial</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../snippets/footer.php"; ?>
</main>

<?php include __DIR__ . "/../snippets/script.php"; ?>
</body>

</html>