<div id="modal" class="row">
    <div class="col col-md-12">
        <form id="formEditarCategorias" method="post" class="modal-editar m-0" onsubmit="return false;"  enctype="multipart/form-data">
            <input type="hidden" id="idCategorias" name="idCategorias">

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
                        <div class="col col-12">
                            <div class="form-group mb-0">
                                <label for="eNome">Nome <span class="text-danger">*</span></label>
                                <input type="text" id="eNome" name="eNome" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right px-3">
                    <button type="button" class="btn btn-outline-light" onclick="jDialog.closeDialog()">Cancelar</button>
                    <button type="submit" onclick="generic.Categorias.editar()" class="btn btn-outline-info">Editar</button>
                </div>
            </div>
        </form>
    </div>
</div>