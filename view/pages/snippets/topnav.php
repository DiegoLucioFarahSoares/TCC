<!-- Topnav -->
<nav class="navbar navbar-top navbar-expand navbar-light border-bottom">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center ml-md-auto">
                <li class="nav-item d-xl-none">
                    <!-- Sidenav toggler -->
                    <div class="pr-3 sidenav-toggler sidenav-toggler-light" data-action="sidenav-pin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="<?php print $sicPath; ?>/assets/img/icon.png">
                            </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm font-weight-bold text-capitalize">
                                    <?php echo $_SESSION['nome']; ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Bem-vindo!</h6>
                        </div>
                        <a href="/meu-perfil" class="dropdown-item" id="Sair">
                            <i class="ni ni-single-02"></i>
                            <span>Meu Perfil</span>
                        </a>
                        <?php if ($adminSIC) { ?>
                        <a href="/gerenciamento/configurar-permissoes" class="dropdown-item" id="Sair">
                            <i class="ni ni-settings-gear-65"></i>
                            <span>Configurar Permissões</span>
                        </a>
                        <?php } ?>
                        <a href="/logout" class="dropdown-item" id="Sair">
                            <i class="ni ni-user-run"></i>
                            <span>Sair</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>