<div id="modal" class="row">
    <div class="col col-md-12">
        <form id="formEditarPessoa" method="post" class="modal-editar m-0" onsubmit="return false;"  enctype="multipart/form-data">
            <input type="hidden" id="idPessoa" name="idPessoa">

            <div class="card mb-0">
                <div class="card-header">
                    <div class="row align-items-top mr-0">
                        <div class="col col-10">
                            <h3 class="card-title m-0">Editar</h3>
                        </div>
                        <div class="col col-2 text-right p-0">
                            <button type="button" class="btn-danger" onclick="jDialog.closeDialog()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="row">
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iNivelAcesso">Nível de Acesso <span class="text-danger">*</span></label>
                                <select id="iNivelAcesso" name="iNivelAcesso"
                                        class="form-control selectpicker" data-actions-box="true"
                                        data-live-search="true" data-size="5">
                                </select>
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iNome">Nome <span class="text-danger">*</span></label>
                                <input type="text" id="iNome" name="iNome" class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iCpf">CPF <span class="text-danger">*</span></label>
                                <input type="text" id="iCpf" name="iCpf" class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-3 col-xl-3">
                            <div class="form-group mb-3">
                                <label for="iRg">RG <span class="text-danger">*</span></label>
                                <input type="text" id="iRg" name="iRg" class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-3 col-xl-3">
                            <div class="form-group mb-3">
                                <label for="iSexo">Sexo <span class="text-danger">*</span></label>
                                <select id="iSexo" name="iSexo"
                                        class="form-control selectpicker" data-actions-box="true"
                                        data-live-search="true" data-size="10">
                                    <option value="">Selecione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-3 col-xl-3">
                            <div class="form-group mb-3">
                                <label for="iDataNascimento">Data de Nascimento <span class="text-danger">*</span></label>
                                <input type="text" id="iDataNascimento" name="iDataNascimento"
                                       class="form-control daterangepicker">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-3 col-xl-3">
                            <div class="form-group mb-3">
                                <label for="iLogin">Login <span class="text-danger">*</span></label>
                                <input type="text" id="iLogin" name="iLogin"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iEmail">E-mail</label>
                                <input type="email" id="iEmail" name="iEmail"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iTelefone">Telefone <span class="text-danger">*</span></label>
                                <input type="text" id="iTelefone" name="iTelefone"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-0">
                                <label for="iCep">CEP <span class="text-danger">*</span></label>
                                <input type="text" id="iCep" name="iCep"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iEstado">Estado <span class="text-danger">*</span></label>
                                <select id="iEstado" name="iEstado"
                                        class="form-control selectpicker" data-actions-box="true"
                                        data-live-search="true" data-size="10">
                                    <option value="">Selecione...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iCidade">Cidade <span class="text-danger">*</span></label>
                                <select id="iCidade" name="iCidade"
                                        class="form-control selectpicker" data-actions-box="true"
                                        data-live-search="true" data-size="10">
                                    <option value="">Selecione...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iLogradouro">Logradouro <span class="text-danger">*</span></label>
                                <input type="text" id="iLogradouro" name="iLogradouro"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-0">
                                <label for="iBairro">Bairro <span class="text-danger">*</span></label>
                                <input type="text" id="iBairro" name="iBairro"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-0">
                                <label for="iNumero">Número <span class="text-danger">*</span></label>
                                <input type="text" id="iNumero" name="iNumero"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-0">
                                <label for="iComplemento">Complemento</label>
                                <input type="text" id="iComplemento" name="iComplemento"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right px-3">
                    <button type="button" class="btn btn-outline-light" onclick="jDialog.closeDialog()">Cancelar</button>
                    <button type="submit" class="btn btn-outline-info" id="btnEditar">Editar</button>
                </div>
            </div>
        </form>
    </div>
</div>