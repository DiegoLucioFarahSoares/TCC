<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-gradient"
     id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="/painel-gestao">
                <img src="<?php print $sicPath; ?>/assets/img/blue.png"
                     class="navbar-brand-img" alt=""/>
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <?php if ($adminSIC) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/painel-gestao/">
                            <i class="ni ni-spaceship text-danger"></i>
                            <span class="nav-link-text">Painel de Gestão</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gerenciamento" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-settings text-dark"></i>
                            <span class="nav-link-text">Gerenciamento</span>
                        </a>
                        <div class="collapse" id="gerenciamento">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="/gerenciamento/pessoa" class="nav-link">
                                        <span class="sidenav-normal">Pessoas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gerenciamento/categorias" class="nav-link">
                                        <span class="sidenav-normal">Categorias</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gerenciamento/midias" class="nav-link">
                                        <span class="sidenav-normal">Mídias</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gerenciamento/cursos" class="nav-link">
                                        <span class="sidenav-normal">Cursos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gerenciamento/treinamentos" class="nav-link">
                                        <span class="sidenav-normal">Treinamentos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gerenciamento/eventos" class="nav-link">
                                        <span class="sidenav-normal">Eventos</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <hr/>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#cursos" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-paper-diploma text-primary"></i>
                            <span class="nav-link-text">Cursos</span>
                        </a>
                        <div class="collapse" id="cursos">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="/cursos/meus-cursos" class="nav-link">
                                        <span class="sidenav-normal"> Meus Cursos </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#treinamentos" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-air-baloon text-primary"></i>
                            <span class="nav-link-text">Treinamentos</span>
                        </a>
                        <div class="collapse" id="treinamentos">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="/treinamentos/meus-treinamentos" class="nav-link">
                                        <span class="sidenav-normal"> Meus Treinamentos </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/eventos">
                            <i class="ni ni-calendar-grid-58 text-warning"></i>
                            <span class="nav-link-text">Eventos</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>