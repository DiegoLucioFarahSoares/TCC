<!-- Main content -->
<div class="main-content" id="panel">

    <!-- Topnav -->
    <?php include __DIR__ . "/../topnav.php"; ?>

    <!-- Header -->
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 d-inline-block mb-0">Painel de Gestão</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-3">
                            <ol class="breadcrumb breadcrumb-links">
                                <li class="breadcrumb-item"><a href=""><i class="ni ni-bulb-61"></i></a></li>
                                <li class="breadcrumb-item"><a href="">Painel de Gestão</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-muted mb-0">Total de Cursos</h5>
                                        <span class="h2 font-weight-bold mb-0"><?= $qtdeCursos ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                            <i class="ni ni-paper-diploma"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 0%</span>
                                    <span class="text-nowrap">Desde o último mês</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-muted mb-0">Total de Treinamentos</h5>
                                        <span class="h2 font-weight-bold mb-0"><?= $qtdeTreinamentos ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                            <i class="ni ni-single-02"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 0%</span>
                                    <span class="text-nowrap">Desde o último mês</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../footer.php"; ?>
</div>