<!-- Main content -->
<div class="main-content" id="detalhes-treinamentos">

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
                    <div class="col col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-top mr-0">
                                    <div class="col col-10">
                                        <h3 class="card-title m-0">Detalhes</h3>
                                    </div>
                                    <div class="col col-2 text-right p-0">
                                        <button type="button" class="btn-danger" id="fechar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body px-4">
                                <div class="row">
                                    <?php
                                    foreach ($retorno as $rs) {
                                        if($rs['status'] == 1) {
                                                ?>
                                        <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                                            <h3 class="card-title mb-4"><?= $rs['nome'];?></h3>

                                            <p class="mb-3">
                                                <?= $rs['descricao'];?>
                                            </p>
                                        </div>
                                    <?php } }  ?>
                                </div>
                            </div>
                            <div class="card-footer text-right px-3">
                                <button type="button" class="btn btn-outline-light" id="fechar">Voltar</button>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../../footer.php"; ?>
</div>