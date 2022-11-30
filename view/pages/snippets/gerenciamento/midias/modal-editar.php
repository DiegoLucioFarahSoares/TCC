<div id="modal" class="row">
    <div class="col col-md-12">
        <form id="formEditarMidias" method="post" class="modal-editar m-0" onsubmit="return false;"  enctype="multipart/form-data">
            <input type="hidden" id="idMidias" name="idMidias">

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
                        <div class="col col-12 col-sm-6 col-md-3 col-xl-3">
                            <div class="form-group mb-3">
                                <label for="iCursos">Cursos <span class="text-danger">*</span></label>
                                <select id="iCursos" name="iCursos"
                                        class="form-control selectpicker" data-actions-box="true"
                                        data-live-search="true" data-size="5">
                                </select>
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-3 col-xl-3">
                            <div class="form-group mb-3">
                                <label for="iNome">Nome <span class="text-danger">*</span></label>
                                <input type="text" id="iNome" name="iNome" class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-3 col-xl-3">
                            <div class="form-group mb-3">
                                <label for="iUrl">Link</label>
                                <input type="text" id="iUrl" name="iUrl" class="form-control">
                            </div>
                        </div>
                        <div class="col col-12 col-sm-6 col-md-3 col-xl-3">
                            <div class="form-group mb-3">
                                <label for="iArquivo">Arquivo (.MP4) <span class="text-danger">*</span></label>
                                <input type="file" id="iArquivo" name="iArquivo[]" class="form-control" accept=".mp4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right px-3">
                    <button type="button" class="btn btn-outline-light" onclick="jDialog.closeDialog()">Cancelar</button>
                    <button type="submit" onclick="generic.Midias.editar()" class="btn btn-outline-info">Editar</button>
                </div>
            </div>
        </form>
    </div>
</div>