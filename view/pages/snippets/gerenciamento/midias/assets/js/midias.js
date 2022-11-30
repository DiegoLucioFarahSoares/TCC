let Midias = function () {

    let self = this;

    /**
     * View Adicionar
     */
    this.adicionar = () => {
        jDialog.openLoading('Carregando....');

        self.view('modal-novo.php', '80%', 0).then((result) => {
            $('#modal select').selectpicker({
                selectAllText: "Todos",
                deselectAllText: "Nenhum",
                noneResultsText: "Nada encontrado",
                noneSelectedText: "Nada encontrado",
                countSelectedText: "{0} itens selecionados",
                language: "pt-BR"
            });

            self.getCursos('#modal #iCursos', true);
        });

        jDialog.updatePosition();
    };

    /**
     * View
     * @param name
     * @param width
     * @param item
     * @returns {Promise<unknown>}
     */
    this.view = (name, width, item) => {
        return new Promise((resolve) => {
            $.ajax({
                url: '/view/pages/snippets/gerenciamento/midias/' + name + '?view=' + Math.random() * 1000,
                beforesend: function () {
                    jDialog.openLoading('Carregando....');
                },
                success: function (html) {
                    jDialog.updatePosition(item);
                    jDialog.openDialog(html, width, '', item, 'zoomIn faster');
                    jDialog.closeLoading();
                    resolve(true);
                },
                error: function (res) {
                    console.error(res);
                    jDialog.closeLoading();
                }
            });
        });
    }

    /**
     * Consultar
     */
    this.consultar = function () {
        let params = {
            nome: $('#nome').val(),
            periodo: $('#periodo').val()
        };

        $.ajax({
            type: 'GET',
            url: '/api/midias/consultar',
            data: params,
            beforeSend: function () {
                jDialog.openLoading('Carregando....');
            },
            complete: function () {
                jDialog.closeLoading();
            },
            success: function (response) {
                if(response.status){
                    let template = $('#templateMidias').html();
                    let html = ejs.compile(template)({dados: response.resultSet});

                    $('#resultadoMidias').html(html);
                    $('#resultadoMidias table').DataTable({
                        language: {
                            "sEmptyTable": "Nenhum registro encontrado.",
                            "sInfo": "Mostrando _START_ de _END_  em um Total de: _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sInfoThousands": ".",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sLoadingRecords": "Carregando...",
                            "sProcessing": "Processando...",
                            "sZeroRecords": "Nenhum registro encontrado.",
                            "sSearch": "Buscar",
                            "oPaginate": {
                                "sNext": "<i class='fas fa-chevron-right'></i>",
                                "sPrevious": "<i class='fas fa-chevron-left'></i>",
                                "sFirst": "<i class='fas fa-angle-double-left'></i>",
                                "sLast": "<i class='fas fa-angle-double-right'></i>"
                            },
                            "oAria": {
                                "sSortAscending": ": Ordenar colunas de forma ascendente",
                                "sSortDescending": ": Ordenar colunas de forma descendente"
                            },
                            "select": {
                                "rows": {
                                    "0": "Nenhuma linha selecionada",
                                    "1": "Selecionado 1 linha",
                                    "_": "Selecionado %d linhas"
                                }
                            },
                            "order": [[ 0, 'desc' ], [ 1, 'desc' ]]
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message ? response.message : 'Tente novamente mais tarde!'
                    });
                }
            },
            error: function (response) {
                self.error(response);
            }
        });
    };

    /**
     * Salvar
     */
    this.salvar = function () {

        const formData = new FormData(document.querySelector('#formNovosMidias'));

        Swal.fire({
            title: 'Você tem certeza que deseja realizar essa operação?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#03A62C',
            cancelButtonColor: '#CC092F',
            confirmButtonText: 'Sim, desejo realizar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    method : 'POST',
                    type   : 'POST',
                    url    : '/api/midias/salvar',
                    data        :   formData,
                    cache       :   false,
                    contentType :   false,
                    enctype     :   'multipart/form-data',
                    processData :   false,
                    beforeSend: function () {
                        jDialog.openLoading('Carregando....');
                    },
                    complete: function () {
                        jDialog.closeLoading();
                    },
                    success: function(res){
                        if(res.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Bom trabalho!',
                                text: 'Operação realizada com sucesso.',
                                showConfirmButton: false,
                                timer: 1000
                            });

                            self.consultar();
                            jDialog.closeDialog();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Não foi possível realizar esta ação, tente novamente mais tarde.'
                            });
                        }
                    },
                    error: function(res){
                        self.error(res);
                    }
                });
            }
        });
    };

    /**
     * View Editar
     * @param idMidias
     * @param nome
     */
    this.viewEditar = (idMidias, idCursos, nome, url, arquivo) => {
        jDialog.openLoading('Carregando....');

        self.view('modal-editar.php', '80%', 0).then((result) => {

            self.getCursos('#modal #iCursos', true);

            $('#modal select').selectpicker({
                selectAllText: "Todos",
                deselectAllText: "Nenhum",
                noneResultsText: "Nada encontrado",
                noneSelectedText: "Nada encontrado",
                countSelectedText: "{0} itens selecionados",
                language: "pt-BR"
            });

            $('#formEditarMidias #idMidias').val(idMidias);
            $('#formEditarMidias #iCursos').val(idCursos).selectpicker("refresh");
            $('#formEditarMidias #iNome').val(nome);
            $('#formEditarMidias #iUrl').val(url);
            $('#formEditarMidias #iArquivo').val(arquivo);

            $('select').selectpicker("refresh");
        });

        jDialog.updatePosition();
    };

    /**
     * Editar
     */
    this.editar = function () {

        const formData = new FormData(document.querySelector('#formEditarMidias'));

        $.ajax({
            method : 'POST',
            type   : 'POST',
            url    : '/api/midias/editar',
            data        :   formData,
            cache       :   false,
            contentType :   false,
            enctype     :   'multipart/form-data',
            processData :   false,
            beforeSend: function () {
                jDialog.openLoading('Carregando....');
            },
            complete: function () {
                jDialog.closeLoading();
            },
            success: function(res) {
                if(res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bom trabalho!',
                        text: 'Operação realizada com sucesso.',
                        showConfirmButton: false,
                        timer: 1000
                    });

                    self.consultar();
                    jDialog.closeDialog();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Não foi possível realizar esta ação, tente novamente mais tarde.'
                    });
                }
            },
            error: function(res) {
                self.error(res);
            }
        })
    };

    /**
     * Excluir
     */
    this.excluir = function (idMidias) {
        Swal.fire({
            title: 'Você tem certeza que deseja realizar essa operação?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#03A62C',
            cancelButtonColor: '#CC092F',
            confirmButtonText: 'Sim, desejo realizar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {

                let params = {
                    idMidias: idMidias
                };

                $.ajax({
                    method : 'POST',
                    type   : 'POST',
                    url: '/api/midias/excluir',
                    data: params,
                    beforeSend: function () {
                        jDialog.openLoading('Carregando....');
                    },
                    complete: function () {
                        jDialog.closeLoading();
                    },
                    success: function(res){
                        if(res.status && res.resultSet) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Bom trabalho!',
                                text: 'Operação realizada com sucesso.',
                                showConfirmButton: false,
                                timer: 1000
                            });

                            self.consultar();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Não foi possível realizar esta ação, tente novamente mais tarde.'
                            });
                        }
                    },
                    error: function(res){
                        self.error(res);
                    }
                });
            }
        });
    };

    /**
     * Status
     * @param idMidias
     */
    this.status = function(idMidias) {
        $.ajax({
            method : 'GET',
            type   : 'GET',
            url:  '/api/midias/status',
            data: {
                idMidias: idMidias,
                status: ($('#status-'+ idMidias +' input[type="checkbox"]').prop('checked')) ? 1 : 2
            },
            beforeSend: function () {
                jDialog.openLoading('Carregando....');
            },
            complete: function () {
                jDialog.closeLoading();
            },
            success: function(res){
                if(res.status){
                    Swal.fire({
                        icon: 'success',
                        title: 'Bom trabalho!',
                        text: 'Operação realizada com sucesso.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text:  res.message
                    });
                }

                jDialog.closeDialog();
            },
            error: function(res){
                self.error(res);
            }
        });
    };

    /**
     * Error
     * @param res
     */
    this.error = function (res) {
        try {
            let retorno = JSON.parse(res.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: retorno.message
            });
        } catch (e) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Não foi possível realizar esta ação, tente novamente mais tarde.'
            });
        }
    };

    /**
     * Limpar os campos do formulário
     */
    this.reset = function () {
        $('#formMidias')[0].reset();
    };

    /**
     * Busca cursos
     * @param id
     * @param selectpicker
     * @returns {Promise<unknown>}
     */
    this.getCursos = function(id, selectpicker) {
        return new Promise((resolve, reject) => {
            $.ajax({
                method : 'GET',
                type   : 'GET',
                async   : false,
                url    : '/api/cursos/getCursos',
                beforeSend: function () {
                    jDialog.openLoading('Carregando....');
                },
                complete: function () {
                    jDialog.closeLoading();
                },
                success: function(res){
                    self.generateSelect(id, res.resultSet, selectpicker);
                    resolve(true);
                },
                error: function(res){
                    self.error(res);
                    reject(false);
                }
            });
        });
    };


    /**
     * formValidate()
     */
    this.formValidate = () => {

        let form = $("#formNovosMidias");

        form.validate({
            rules: {
                iCursos: {
                    required: true
                },
                iNome: {
                    required: true,
                    minlength : 5,
                    maxlength : 85
                },
                iArquivo: {
                    required: true
                },
            },
            messages: {
                iCursos: {
                    required: "Campo obrigatório"
                },
                iNome: {
                    required: "Campo obrigatório",
                    minlength : "Informe no mínimo 5 caracteres",
                    maxlength : "Informe no máximo 85 caracteres"
                },
                iArquivo: {
                    required: "Campo obrigatório"
                },
            },
            submitHandler: () => {
                self.salvar();
            }
        });
    };

    /**
     * Gera select
     * @param id
     * @param result
     * @param selectpicker
     * @param mensagem
     */
    this.generateSelect = function(id, result, selectpicker, mensagem){
        let html = '<option value="">Nada encontrado</option>';

        if(result.length > 0){
            if(!mensagem)
                html = '<option value="">Selecione...</option>';

            result.forEach(function(option){
                html += '<option value="'+ option['codigo'] +'">'+ option['nome'] +'</option>';
            });
        }

        $(id).html(html);

        if(selectpicker)
            $(id).selectpicker("refresh");
    };

    /**
     * Inicialização
     */
    this.init = function () {
        /**
         * Lightpick
         */
        new Lightpick({
            field: document.getElementById('periodo'),
            singleDate: false,
            maxDate: new Date(),
            locale: {
                tooltip: {
                    one: 'dia',
                    other: 'dias'
                }
            }
        });
    };
};

let _midias = new Midias();

$(document).ready(function() {
    $(document).on('click', '#formNovosMidias #btnSalvar', function () {
        _midias.formValidate();
    });
});