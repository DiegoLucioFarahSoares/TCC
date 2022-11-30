<div id="modal" class="row">
    <div class="col col-md-12">
        <form id="formNovosTreinamentos" method="post" class="modal-novo m-0" onsubmit="return false;" enctype="multipart/form-data">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="row align-items-top mr-0">
                        <div class="col col-10">
                            <h3 class="card-title m-0">Adicionar</h3>
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
                                <label for="iPessoa">Pessoa </label>
                                <select id="iPessoa" name="iPessoa"
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
                                <label for="iFoto">Imagem <span class="text-danger">*</span></label>
                                <input type="file" id="iFoto" name="iFoto[]" class="form-control" accept="image/*,application">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iDataInicio">Data Início <span class="text-danger">*</span></label>
                                <input type="text" id="iDataInicio" name="iDataInicio"
                                       class="form-control daterangepicker">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iDataFim">Data Fim <span class="text-danger">*</span></label>
                                <input type="text" id="iDataFim" name="iDataFim"
                                       class="form-control daterangepicker">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iHoras">Horas <span class="text-danger">*</span></label>
                                <input type="time" id="iHoras" name="iHoras" class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-12 col-xl-12">
                            <div class="form-group mb-3">
                                <label for="iDescricao">Descrição <span class="text-danger">*</span></label>
                                <textarea name="iDescricao" id="iDescricao" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right px-3">
                    <button type="button" class="btn btn-outline-light" onclick="jDialog.closeDialog()">Cancelar</button>
                    <button type="submit" class="btn btn-outline-success" id="btnSalvar">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>