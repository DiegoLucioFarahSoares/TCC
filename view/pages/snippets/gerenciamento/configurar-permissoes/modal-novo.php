<div id="modal" class="row">
    <div class="col col-md-12">
        <form id="formNovoNivelPermissoes" method="post" class="modal-novo m-0" onsubmit="return false;"  enctype="multipart/form-data">
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
                        <div class="col col-12">
                            <div class="form-group mb-0">
                                <label for="iNome">Nome <span class="text-danger">*</span></label>
                                <input type="text" id="iNome" name="iNome" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right px-3">
                    <button type="button" class="btn btn-outline-light" onclick="jDialog.closeDialog()">Cancelar</button>
                    <button type="submit" onclick="generic.ConfigurarPermissoes.salvar()" class="btn btn-outline-success">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>