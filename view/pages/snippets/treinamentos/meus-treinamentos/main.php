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
                        <h6 class="h2 d-inline-block mb-0">Treinamentos</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-3">
                            <ol class="breadcrumb breadcrumb-links">
                                <li class="breadcrumb-item"><a href=""><i class="ni ni-air-baloon"></i></a></li>
                                <li class="breadcrumb-item"><a href="">Meus Treinamentos</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 mt-lg-0 mt-4">
                        <div class="row">

                            <?php
                            foreach ($retorno as $rs) {
                            if($rs['status'] == 1) {
                                ?>
                                <div class="col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <div class="avatar avatar-xl bg-default border-radius-md p-1 mr-3">
                                                    <img src="<?= $rs['img'];?>" alt="" class="img-fluid shadow border-radius-xl">
                                                </div>
                                                <div class="ms-3 my-auto w-75">
                                                    <h3><?= $rs['nome'];?></h3>
                                                </div>
                                                <div class="ms-auto">
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-sm btn-neutral text-default mr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                                            <a href="/treinamentos/meus-treinamentos/detalhes/?cod=<?= $rs['idTreinamentos'];?>" class="dropdown-item">
                                                                Quero fazer esse treinamento
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-sm mt-3 mb-2" id="descricao"><?= $rs['descricao'];?></p>
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <h6 class="text-sm mb-0"><?= $rs['total'];?></h6>
                                                    <p class="text-info text-sm font-weight-bold mb-0">Participantes</p>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <h6 class="text-sm mb-0"><?= $rs['horas'];?></h6>
                                                    <p class="text-info text-sm font-weight-bold mb-0">Carga Horária</p>
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
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../../footer.php"; ?>
</div>