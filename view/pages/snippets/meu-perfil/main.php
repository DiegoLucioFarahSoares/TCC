<!-- Main content -->
<div class="main-content" id="pessoa">

    <!-- Topnav -->
    <?php include __DIR__ . "/../topnav.php"; ?>

    <!-- Header -->
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-12 col-12">
                        <h6 class="h2 d-inline-block mb-0">Meu Perfil</h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-xl-12">
                        <div id="resultadoMeuPerfil"></div>
                        <script id="templateMeuPerfil" type="text/template">
                            <div class="card">
                                <div class="card-header mb-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="mb-0">Minhas Informações</h3>
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
                                            <th scope="col">Dados Pessoais</th>
                                            <th scope="col">Endereço</th>
                                            <th scope="col">Nível de Acesso</th>
                                            <th scope="col">Ativo</th>
                                            <th scope="col" style="width: 2%">Ação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <%
                                        for (let dado of dados) {
                                        let idPessoa = dado['idPessoa'];
                                        let login = dado['login'];
                                        let dataCadastro = dado['dataCadastro'];
                                        let nome = dado['nome'];
                                        let cpf = dado['cpf'];
                                        let rg = dado['rg'];
                                        let sexo = dado['sexo'];
                                        let dataNascimento = dado['dataNascimento'];
                                        let email = dado['email'];
                                        let telefone = dado['telefone'];
                                        let logradouro = dado['logradouro'];
                                        let bairro = dado['bairro'];
                                        let cep = dado['cep'];
                                        let estado = dado['estado'];
                                        let idEstado = dado['idEstado'];
                                        let cidade = dado['cidade'];
                                        let idCidade = dado['idCidade'];
                                        let numero = dado['numero'];
                                        let complemento = dado['complemento'];
                                        let idNivelAcesso = dado['idNivelAcesso'];
                                        let nivel = dado['nivel'];
                                        let status = dado['status'];
                                        %>
                                        <tr>
                                            <td class="text-center"><%= idPessoa %></td>
                                            <td><%= dataCadastro%></td>
                                            <td>
                                                Nome: <%= nome%><br>
                                                CPF: <%= cpf%><br>
                                                RG: <%= rg%><br>
                                                Sexo: <%= sexo%><br>
                                                Data de nascimento: <%= dataNascimento%><br>
                                                E-mail: <%= email%><br>
                                                Telefone: <%= telefone%>
                                            </td>
                                            <td>
                                                Logradouro: <%= logradouro%><br>
                                                Bairro: <%= bairro%><br>
                                                CEP: <%= cep%><br>
                                                Estado: <%= estado%><br>
                                                Cidade: <%= cidade%><br>
                                                Número: <%= numero%><br>
                                                Complemento: <%= complemento%>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><%= nivel%></span>
                                            </td>
                                            <td>
                                                <% if(status == 1) { %>
                                                <span class="badge badge-success">
                                                    Ativo
                                                </span>
                                                <% } else { %>
                                                <span class="badge badge-danger">
                                                    Inativo
                                                </span>
                                                <% } %>
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
                                                           onclick="generic.MeuPerfil.viewEditar('<%= idPessoa %>', '<%= nome %>', '<%= login %>', '<%= cpf %>', '<%= rg %>', '<%= sexo %>', '<%= dataNascimento %>', '<%= email %>', '<%= telefone %>', '<%= logradouro %>', '<%= bairro %>', '<%= cep %>', '<%= numero %>', '<%= idNivelAcesso %>', '<%= complemento %>', '<%= estado %>', '<%= cidade %>')"
                                                           target="_self" id="update">Editar</a>
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
    <?php include __DIR__ . "/../footer.php"; ?>
</div>