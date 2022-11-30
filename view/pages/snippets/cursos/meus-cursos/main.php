<!-- Main content -->
<div class="main-content" id="panel">

    <!-- Topnav -->
    <?php include __DIR__ . "/../../topnav.php"; ?>

    <!-- Header -->
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 d-inline-block mb-0">Cursos</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-3">
                            <ol class="breadcrumb breadcrumb-links">
                                <li class="breadcrumb-item"><a href=""><i class="ni ni-paper-diploma"></i></a></li>
                                <li class="breadcrumb-item"><a href="">Meus Cursos</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">

                    <?php
                        foreach ($retorno as $rs) {
                        if($rs['status'] == 1) {
                    ?>
                    <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                        <div class="card p-3">
                            <div class="position-relative">
                                <a class="d-block shadow-xl">
                                    <img src="<?= $rs['img'];?>" alt="" class="img-fluid shadow border-radius-xl">
                                </a>
                            </div>
                            <div class="card-body px-1 pb-0">
                                <p class="text-primary mb-2 text-sm"><?= $rs['nomeCategoria'];?></p>
                                <a href="/cursos/meus-cursos/detalhes/?cod=<?= $rs['idCursos'];?>">
                                    <h3>
                                        <?= $rs['nome'];?>
                                    </h3>
                                </a>
                                <p class="mb-4 text-sm" id="descricao">
                                    <?= $rs['descricao'];?>
                                </p>
                                <div class="w-100 mb-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="me-2 text-sm font-weight-bold text-capitalize">Andamento</span>
                                        <span class="ms-auto text-sm font-weight-bold">0%</span>
                                    </div>
                                    <div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-gradient-info w-0" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="/cursos/meus-cursos/detalhes/?cod=<?= $rs['idCursos'];?>" class="btn btn-outline-info mb-0">
                                        Quero fazer esse curso
                                    </a>
                                    <div class="col-4 text-end p-0">
                                        <h6 class="text-sm mb-0"><?= $rs['dataCadastro'];?></h6>
                                        <p class="text-info text-sm font-weight-bold mb-0">Publicado</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../../footer.php"; ?>
</div>