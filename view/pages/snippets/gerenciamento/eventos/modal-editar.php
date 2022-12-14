<div id="modal" class="row">
    <div class="col col-md-12">
        <form id="formEditarEventos" method="post" class="modal-editar m-0" onsubmit="return false;">
            <input type="hidden" id="idEventos" name="idEventos">

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
                                <label for="iDescricao">Descri????o <span class="text-danger">*</span></label>
                                <input type="text" id="iDescricao" name="iDescricao" class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-4 col-xl-4">
                            <div class="form-group mb-3">
                                <label for="iDataInicio">Data In??cio <span class="text-danger">*</span></label>
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
                    </div>
                </div>
                <div class="card-footer text-right px-3">
                    <button type="button" class="btn btn-outline-light" onclick="jDialog.closeDialog()">Cancelar</button>
                    <button type="submit" onclick="generic.Eventos.editar()" class="btn btn-outline-info">Editar</button>
                </div>
            </div>
        </form>
    </div>
</div>