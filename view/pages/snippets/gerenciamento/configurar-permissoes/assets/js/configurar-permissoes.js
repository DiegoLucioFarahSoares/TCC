let ConfigurarPermissoes = function () {

    let self = this;

    /**
     * View Adicionar
     */
    this.adicionar = () => {
        jDialog.openLoading('Carregando....');

        self.view('modal-novo.php', '80%', 0).then((result) => {});

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
                url: '/view/pages/snippets/gerenciamento/configurar-permissoes/' + name + '?view=' + Math.random() * 1000,
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
            url: '/api/permissoes/consultar',
            data: params,
            beforeSend: function () {
                jDialog.openLoading('Carregando....');
            },
            complete: function () {
                jDialog.closeLoading();
            },
            success: function (response) {
                if(response.status){
                    let template = $('#templateConfigurarPermissoes').html();
                    let html = ejs.compile(template)({dados: response.resultSet});

                    $('#resultadoConfigurarPermissoes').html(html);
                    $('#resultadoConfigurarPermissoes table').DataTable({
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

            let params = {
                nome: $('#iNome').val()
            };

            if (result.value) {
                $.ajax({
                    method : 'POST',
                    type   : 'POST',
                    url: '/api/permissoes/salvar',
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
     * @param idNivelAcesso
     * @param nome
     */
    this.viewEditar = (idNivelAcesso, nome) => {
        jDialog.openLoading('Carregando....');

        self.view('modal-editar.php', '80%', 0).then((result) => {
            $('#formEditarNivelPermissoes #idNivelAcesso').val(idNivelAcesso);
            $('#formEditarNivelPermissoes #eNome').val(nome);
        });

        jDialog.updatePosition();
    };

    /**
     * Editar
     */
    this.editar = function () {
        let params = {
            idNivelAcesso: $('#idNivelAcesso').val(),
            nome: $('#eNome').val()
        };

        $.ajax({
            method: 'POST',
            type: 'POST',
            url: '/api/permissoes/editar',
            data: params,
            async: true,
            beforeSend: function () {
                jDialog.openLoading('Carregando....');
            },
            complete: function () {
                jDialog.closeLoading();
            },
            success: function(res) {
                if(res.status && res.resultSet) {
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
    this.excluir = function (idNivelAcesso) {
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
                    idNivelAcesso: idNivelAcesso
                };

                $.ajax({
                    method : 'POST',
                    type   : 'POST',
                    url: '/api/permissoes/excluir',
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
        $('#formConfigurarPermissoes')[0].reset();
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