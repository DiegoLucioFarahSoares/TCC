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
                        <h6 class="h2 d-inline-block mb-0">Eventos</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-3">
                            <ol class="breadcrumb breadcrumb-links">
                                <li class="breadcrumb-item"><a href=""><i class="ni ni-calendar-grid-58"></i></a></li>
                                <li class="breadcrumb-item"><a href="">Acompanhar</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div id='calendar' class="mb-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../footer.php"; ?>
</div>