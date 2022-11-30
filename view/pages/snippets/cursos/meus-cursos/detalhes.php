<!-- Main content -->
<div class="main-content" id="detalhes">

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

                <div class="exibir-detalhes">
                    <?php
                    foreach ($retorno as $rs) {
                        if($rs['status'] == 1) {
                            ?>
                            <div class="row">
                                <div class="col-xl-7">
                                    <div class="card">
                                        <div class="card-header d-flex pb-0 p-3">
                                            <h3 class="my-auto">Detalhes</h3>
                                        </div>
                                        <div class="card-body p-3">
                                            <img src="<?= $rs['img'];?>" alt="" class="img-fluid shadow border-radius-xl">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 ms-auto mt-xl-0 mt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        <div class="col-12 my-auto">
                                                            <h3>
                                                                <?= $rs['nome'];?>
                                                            </h3>
                                                            <div class="rating text-info">
                                                                <i class="fas fa-star" aria-hidden="true"></i>
                                                                <i class="fas fa-star" aria-hidden="true"></i>
                                                                <i class="fas fa-star" aria-hidden="true"></i>
                                                                <i class="fas fa-star" aria-hidden="true"></i>
                                                                <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                                                            </div>
                                                            <span class="badge badge-success mt-3"><?= $rs['nomeCategoria'];?></span>
                                                            <br>
                                                            <label class="mt-3">Descrição</label>
                                                            <ul>
                                                                <li><?= $rs['descricao'];?></li>
                                                            </ul>
                                                            <div class="w-100 mb-4">
                                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                                    <span class="me-2 text-sm font-weight-bold">O seu andamento está em</span>
                                                                    <span class="ms-auto text-sm font-weight-bold">0%</span>
                                                                </div>
                                                                <div>
                                                                    <div class="progress progress-md">
                                                                        <div class="progress-bar bg-gradient-info w-0" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <button type="button" class="btn btn-info mb-0 w-100" id="salaAula">Sala de aula</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } } ?>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h3 class="ms-3">Mais Cursos</h3>
                            <div class="table table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-primary text-xxs font-weight-bolder opacity-7">Curso</th>
                                        <th class="text-primary text-xxs font-weight-bolder opacity-7 ps-2">Categoria</th>
                                        <th class="text-primary text-xxs font-weight-bolder opacity-7 ps-2">Avaliação do Curso</th>
                                        <!--                                        <th class="text-center text-primary text-xxs font-weight-bolder opacity-7">Desempenho</th>-->
                                        <th class="text-center text-primary text-xxs font-weight-bolder opacity-7" style="width: 8%">Ação</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($retornoMaisCursos as $rs) {
                                        if($rs['idCursos'] != $_GET['cod'] && $rs['status'] == 1) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="mr-3">
                                                            <img src="<?= $rs['img'];?>" class="avatar avatar-md me-3" alt="">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm"><?= $rs['nome'];?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-sm">
                                                    <span class="badge badge-info mt-3"><?= $rs['nomeCategoria'];?></span>
                                                </td>
                                                <td>
                                                    <div class="rating text-info ms-lg-n4">
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="/cursos/meus-cursos/detalhes/?cod=<?= $rs['idCursos'];?>" class="btn btn-outline-info mb-0 w-100">
                                                        Quero fazer esse curso
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="exibir-sala-aula">
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-top mr-0">
                                        <div class="col col-10">
                                            <h3 class="card-title m-0">Sala de aula</h3>
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
                                        foreach ($retornoMidias as $rs) {
                                            if($rs['status'] == 1) {
                                                if (isset($rs['arquivo']) && !empty($rs['arquivo'])) {
                                                ?>
                                                <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                                                    <h3 class="card-title mb-4"><?= $rs['nome'];?></h3>
                                                    <video controls class="w-100 mb-3">
                                                        <source src="<?= $rs['arquivo'];?>" type="video/mp4">
                                                    </video>
                                                </div>
                                        <?php } } } ?>
                                    </div>
                                </div>
                                <div class="card-footer text-right px-3">
                                    <button type="button" class="btn btn-outline-light" id="fechar">Fechar</button>
                                </div>
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