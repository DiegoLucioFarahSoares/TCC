<!-- Main content -->
<div class="main-content" id="treinamentos">

    <!-- Topnav -->
    <?php include __DIR__ . "/../../topnav.php"; ?>

    <!-- Header -->
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 d-inline-block mb-0">Gerenciamento de Treinamentos</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <button type="button" class="btn btn-primary" onclick="generic.Treinamentos.adicionar()">
                            Adicionar
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <form id="formTreinamentos" method="post" class="modal-insert m-0" onsubmit="return false;"
                              enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-top mr-0">
                                        <div class="col col-12">
                                            <h3 class="mb-0">Consultar Treinamentos</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 col-xl-6">
                                            <label for="nome">Nome</label>
                                            <input type="text" id="nome" name="nome" class="form-control">
                                        </div>
                                        <div class="col-6 col-xl-6">
                                            <label for="periodo">Período</label>
                                            <input type="text" id="periodo" name="periodo"
                                                   class="form-control daterangepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="button" class="btn btn-outline-light"
                                            onclick="generic.Treinamentos.reset()">
                                        Cancelar
                                    </button>
                                    <button onclick="generic.Treinamentos.consultar()"
                                            class="btn btn-outline-info">
                                        Consultar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-xl-12">
                        <div id="resultadoTreinamentos"></div>
                        <script id="templateTreinamentos" type="text/template">
                            <div class="card">
                                <div class="card-header mb-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="mb-0">Lista de Treinamentos</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive mb-3">
                                    <table class="table table-hover align-items-center table-flush">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 2%">#Cód.
                                            </th>
                                            <th scope="col">Data de Cadastro</th>
                                            <th scope="col">Treinamentos</th>
                                            <th scope="col">Ativo</th>
                                            <th scope="col" style="width: 2%">Ação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <%
                                        for (let dado of dados) {
                                        let idTreinamentos = dado['idTreinamentos'];
                                        let idPessoa = dado['idPessoa'];
                                        let nome = dado['nome'];
                                        let descricao = dado['descricao'];
                                        let dataCadastro = dado['dataCadastro'];
                                        let horas = dado['horas'];
                                        let dataInicio = dado['dataInicio'];
                                        let dataFim = dado['dataFim'];
                                        let status = dado['status'];
                                        %>
                                        <tr>
                                            <td class="text-center"><%= idTreinamentos %></td>
                                            <td><%= dataCadastro%></td>
                                            <td>
                                                Nome: <%= nome%><br>
                                                Data Início: <%= dataInicio%><br>
                                                Data Fim: <%= dataFim%><br>
                                                Horas: <%= horas%>
                                            </td>
                                            <td>
                                                <label id="status-<%= idTreinamentos %>" class="custom-toggle">
                                                    <input type="checkbox" onclick="generic.Treinamentos.status('<%= idTreinamentos %>')" <%= status == 1 ? 'checked' : '' %>>
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="Não" data-label-on="Sim"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" role="button"
                                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                       target="_self">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item"
                                                           onclick="generic.Treinamentos.viewEditar('<%= idTreinamentos %>', '<%= idPessoa %>', '<%= nome %>', '<%= horas %>', '<%= dataInicio %>', '<%= dataFim %>')"
                                                           target="_self">Editar</a>
                                                        <a class="dropdown-item"
                                                           onclick="generic.Treinamentos.excluir('<%= idTreinamentos %>')"
                                                           target="_self">Excluir</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <% } %>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </script>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../../footer.php"; ?>
</div>