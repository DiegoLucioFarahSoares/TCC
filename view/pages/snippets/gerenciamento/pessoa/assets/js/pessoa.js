let Pessoa = function () {

    let self = this;

    /**
     * View Adicionar
     */
    this.adicionar = () => {
        jDialog.openLoading('Carregando....');

        self.view('modal-novo.php', '80%', 0).then((result) => {
            if (result) {

                $('#iTelefone').mask('(00) 0000-0000');
                $('#iCep').mask('00000-000');
                $('#iCpf').mask('000.000.000-00', {reverse: true});
                $('#iRg').mask('99.999.999-9');

                let form = document.querySelector('#formNovaPessoa');

                const estados = Object.entries(EEstados);

                const selects = $('form select');

                estados.forEach((estado) => {
                    form['iEstado'].appendChild(new Option(estado[1], estado[0]));
                });

                form['iEstado'].addEventListener('change', () => {
                    self.getCidades('#modal #iCidade', true);
                });

                selects.selectpicker({
                    language: "pt-BR",
                    noneResultsText: "Nada encontrado",
                    noneSelectedText: "Nada encontrado"
                });

                const dataNascimento = new Lightpick({
                    field: form['iDataNascimento'],
                    singleDate: true,
                    footer: true,
                    locale: {
                        buttons: {
                            prev: '&leftarrow;',
                            next: '&rightarrow;',
                            close: '&times;',
                            reset: 'Limpar',
                            apply: 'Aplicar'
                        }
                    },
                    onClose: () => {

                        const date = form['iDataNascimento'].value;
                        form['iDataNascimento'].dataset.date = '';

                        if(date !== null){
                            form['iDataNascimento'].dataset.date = date.split('/').reverse().join('-');
                        }
                    }
                });

                dataNascimento._opts.firstDay = 0;
            }
        });

        self.getNivelAcesso('#modal #iNivelAcesso', true);

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
                url: '/view/pages/snippets/gerenciamento/pessoa/' + name + '?view=' + Math.random() * 1000,
                async   : false,
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
            url: '/api/pessoa/consultar',
            data: params,
            beforeSend: function () {
                jDialog.openLoading('Carregando....');
            },
            complete: function () {
                jDialog.closeLoading();
            },
            success: function (response) {
                if(response.status){
                    let template = $('#templatePessoa').html();
                    let html = ejs.compile(template)({dados: response.resultSet});

                    $('#resultadoPessoa').html(html);
                    $('#resultadoPessoa table').DataTable({
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
     * formValidateNovo()
     */
    this.formValidateNovo = () => {

        let form = $("#formNovaPessoa");

        $.validator.addMethod("isCPFValid", (value) => settings.cpf(value));

        $.validator.addMethod("isYear18", (value, element) => settings.diffYears(element.dataset.date) > 18);

        $.validator.addMethod("isFone", (value, element) => {
            if (!element.getAttribute('required') && value === '') {
                return true;
            }

            return this.isFone(element);
        });

        form.validate({
            rules: {
                iNivelAcesso: {
                    required: true
                },
                iNome: {
                    required: true,
                    minlength : 5,
                    maxlength : 85
                },
                iCpf: {
                    isCPFValid: true
                },
                iRg: {
                    required: true
                },
                iSexo: {
                    required: true
                },
                iDataNascimento: {
                    isYear18: true
                },
                iLogin: {
                    required: true
                },
                iTelefone: {
                    isFone: true
                },
                iCep: {
                    required: true
                },
                iEstado: {
                    required: true
                },
                iCidade: {
                    required: true
                },
                iLogradouro: {
                    required: true
                },
                iBairro: {
                    required: true
                },
                iNumero: {
                    required: true
                },
            },
            messages: {
                iNivelAcesso: {
                    required: "Campo obrigatório"
                },
                iNome: {
                    required: "Campo obrigatório",
                    minlength : "Informe no mínimo 5 caracteres",
                    maxlength : "Informe no máximo 85 caracteres"
                },
                iCpf: {
                    isCPFValid: `CPF inválido`
                },
                iRg: {
                    required: "Campo obrigatório"
                },
                iSexo: {
                    required: "Campo obrigatório"
                },
                iDataNascimento: {
                    isYear18: `A data informada deve ser superior a 18 anos.`
                },
                iLogin: {
                    required: "Campo obrigatório"
                },
                iTelefone: {
                    isFone: `Número de telefone inválido.`
                },
                iCep: {
                    required: "Campo obrigatório"
                },
                iEstado: {
                    required: "Campo obrigatório"
                },
                iCidade: {
                    required: "Campo obrigatório"
                },
                iLogradouro: {
                    required: "Campo obrigatório"
                },
                iBairro: {
                    required: "Campo obrigatório"
                },
                iNumero: {
                    required: "Campo obrigatório"
                },
            },
            onkeyup: (input) => {
                switch (input.name) {
                    case 'iRg':
                        input.value = input.value.replace(/[^a-z^0-9]+/g, "");
                        break;
                    case 'iNome':
                        input.value = input.value.replace(/\d/g, '');
                        input.value = input.value.replace(/\s\s+/g, ' ');
                        break;
                }
            },
            onfocusout: (input) => {
                input.value = input.value.trim();
            },
            submitHandler: () => {
                self.salvar();
            },
            invalidHandler: (event)=>  {
                event.preventDefault();
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

            if (result.value) {
                $.ajax({
                    method : 'POST',
                    type   : 'POST',
                    url: '/api/pessoa/salvar',
                    data: $('#formNovaPessoa').serializeArray(),
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

                            setTimeout(function() {
                                self.consultar();
                            }, 1200);

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
     */
    this.viewEditar = (idPessoa, nome, login, cpf, rg, sexo, iDataNascimento, email, telefone, logradouro, bairro, cep, numero, idNivelAcesso, complemento, uf, cidade) => {
        jDialog.openLoading('Carregando....');

        $('select').selectpicker("refresh");

        self.view('modal-editar.php', '80%', 0).then((result) => {
            if (result) {

                $('#formEditarPessoa #idPessoa').val(idPessoa);
                $('#formEditarPessoa #iNome').val(nome);
                $('#formEditarPessoa #iCpf').val(cpf);
                $('#formEditarPessoa #iRg').val(rg);
                $('#formEditarPessoa #iSexo').val(sexo).selectpicker("refresh");
                $('#formEditarPessoa #iDataNascimento').val(iDataNascimento);
                $('#formEditarPessoa #iLogin').val(login);
                $('#formEditarPessoa #iEmail').val(email);
                $('#formEditarPessoa #iTelefone').val(telefone);
                $('#formEditarPessoa #iLogradouro').val(logradouro);
                $('#formEditarPessoa #iBairro').val(bairro);
                $('#formEditarPessoa #iCep').val(cep);
                $('#formEditarPessoa #iEstado').val(uf).selectpicker("refresh");
                $('#formEditarPessoa #iCidade').val(cidade).selectpicker("refresh");
                $('#formEditarPessoa #iNumero').val(numero);
                $('#formEditarPessoa #iComplemento').val(complemento);
                $('#formEditarPessoa #iNivelAcesso').val(idNivelAcesso).selectpicker("refresh");

                $('#iTelefone').mask('(00) 0000-0000');
                $('#iCep').mask('00000-000');
                $('#iCpf').mask('000.000.000-00', {reverse: true});
                $('#iRg').mask('99.999.999-9');

                let iForm = document.querySelector('#formEditarPessoa');

                const iEstados = Object.entries(EEstados);

                const selects = $('form select');

                iEstados.forEach((estado) => {
                    iForm['iEstado'].appendChild(new Option(estado[1], estado[0]));
                });

                iForm['iEstado'].addEventListener('change', () => {
                    self.getCidades('#modal #iCidade', true);
                });

                selects.selectpicker({
                    language: "pt-BR",
                    noneResultsText: "Nada encontrado",
                    noneSelectedText: "Nada encontrado"
                });

                const dataNascimento = new Lightpick({
                    field: iForm['iDataNascimento'],
                    singleDate: true,
                    footer: true,
                    locale: {
                        buttons: {
                            prev: '&leftarrow;',
                            next: '&rightarrow;',
                            close: '&times;',
                            reset: 'Limpar',
                            apply: 'Aplicar'
                        }
                    },
                    onClose: () => {

                        const date = iForm['iDataNascimento'].value;
                        iForm['iDataNascimento'].dataset.date = '';

                        if(date !== null){
                            iForm['iDataNascimento'].dataset.date = date.split('/').reverse().join('-');
                        }
                    }
                });

                dataNascimento._opts.firstDay = 0;

                $('select').selectpicker("refresh");
            }
        });

        self.getNivelAcesso('#modal #iNivelAcesso', true);

        jDialog.updatePosition();
    };

    /**
     * Editar
     */
    this.editar = function () {
        $.ajax({
            method: 'POST',
            type: 'POST',
            url: '/api/pessoa/editar',
            data: $('#formEditarPessoa').serializeArray(),
            async: true,
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

                    setTimeout(function() {
                        self.consultar();
                    }, 1200);

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
     * formValidateEditar()
     */
    this.formValidateEditar = () => {

        let form = $("#formEditarPessoa");

        $.validator.addMethod("isCPFValid", (value) => settings.cpf(value));

        $.validator.addMethod("isYear18", (value, element) => settings.diffYears(element.dataset.date) > 18);

        $.validator.addMethod("isFone", (value, element) => {
            if (!element.getAttribute('required') && value === '') {
                return true;
            }

            return this.isFone(element);
        });

        form.validate({
            rules: {
                iNivelAcesso: {
                    required: true
                },
                iNome: {
                    required: true,
                    minlength : 5,
                    maxlength : 85
                },
                iCpf: {
                    isCPFValid: true
                },
                iRg: {
                    required: true
                },
                iSexo: {
                    required: true
                },
                iDataNascimento: {
                    isYear18: true
                },
                iLogin: {
                    required: true
                },
                iTelefone: {
                    isFone: true
                },
                iCep: {
                    required: true
                },
                iEstado: {
                    required: true
                },
                iCidade: {
                    required: true
                },
                iLogradouro: {
                    required: true
                },
                iBairro: {
                    required: true
                },
                iNumero: {
                    required: true
                },
            },
            messages: {
                iNivelAcesso: {
                    required: "Campo obrigatório"
                },
                iNome: {
                    required: "Campo obrigatório",
                    minlength : "Informe no mínimo 5 caracteres",
                    maxlength : "Informe no máximo 85 caracteres"
                },
                iCpf: {
                    isCPFValid: `CPF inválido`
                },
                iRg: {
                    required: "Campo obrigatório"
                },
                iSexo: {
                    required: "Campo obrigatório"
                },
                iDataNascimento: {
                    isYear18: `A data informada deve ser superior a 18 anos.`
                },
                iLogin: {
                    required: "Campo obrigatório"
                },
                iTelefone: {
                    isFone: `Número de telefone inválido.`
                },
                iCep: {
                    required: "Campo obrigatório"
                },
                iEstado: {
                    required: "Campo obrigatório"
                },
                iCidade: {
                    required: "Campo obrigatório"
                },
                iLogradouro: {
                    required: "Campo obrigatório"
                },
                iBairro: {
                    required: "Campo obrigatório"
                },
                iNumero: {
                    required: "Campo obrigatório"
                },
            },
            onkeyup: (input) => {
                switch (input.name) {
                    case 'iRg':
                        input.value = input.value.replace(/[^a-z^0-9]+/g, "");
                        break;
                    case 'iNome':
                        input.value = input.value.replace(/\d/g, '');
                        input.value = input.value.replace(/\s\s+/g, ' ');
                        break;
                }
            },
            onfocusout: (input) => {
                input.value = input.value.trim();
            },
            submitHandler: () => {
                self.editar();
            },
            invalidHandler: (event)=>  {
                event.preventDefault();
            }
        });
    };

    /**
     * Excluir
     */
    this.excluir = function (idPessoa) {
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
                    idPessoa: idPessoa
                };

                $.ajax({
                    method : 'POST',
                    type   : 'POST',
                    url: '/api/pessoa/excluir',
                    data: params,
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

                            setTimeout(function() {
                                self.consultar();
                            }, 1200);

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
        $('#formPessoa')[0].reset();
    };

    /**
     * getCep()
     * @param target
     * @param acao
     */
    this.getCep = (target, acao) => {

        let cep = target.value;
        let validacep = /^[0-9]{8}$/;

        let form = document.querySelector('#'+acao);

        self.clearEndereco(form);

        jDialog.openLoading();

        if (validacep.test(cep.replace(/\D/g, ''))) {

            $.getJSON("//viacep.com.br/ws/" + cep.replace(/\D/g, '') + "/json/", function (dados) {

                jDialog.closeLoading();

                if (!("erro" in dados)) {
                    form['iLogradouro'].value = dados.logradouro.toUpperCase();
                    form['iBairro'].value = dados.bairro.toUpperCase();
                    form['iEstado'].value = dados.uf.toUpperCase();
                    form['iCidade'].appendChild(new Option(dados.localidade.toUpperCase(), dados.ibge, true, true));

                    $('select#iEstado, select#iCidade').selectpicker('refresh');

                    if(settings.isEmpty(dados.bairro)){
                        form['iBairro'].removeAttribute('readonly');
                    }

                    if(settings.isEmpty(dados.logradouro)){
                        form['iLogradouro'].removeAttribute('readonly');
                    }
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "CEP não encontrado."
                    });
                }

            });
        }
        else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Formato de CEP inválido."
            });
        }
    };

    /**
     * Limpa os campos endereço
     * @param form
     */
    this.clearEndereco = function(form) {
        form['iLogradouro'].value = '';
        form['iBairro'].value = '';
        form['iNumero'].value = '';
        form['iComplemento'].value = '';
        form['iEstado'].value = '';
        form['iCidade'].value = '';

        let options = form['iCidade'].querySelectorAll('option');

        if(options.length > 0){
            options.forEach((o) => o.remove());
        }

        form['iBairro'].setAttribute('readonly', 'readonly');
        form['iLogradouro'].setAttribute('readonly', 'readonly');

        $('select#iEstado, select#iCidade').selectpicker('refresh');
    };

    /**
     * isFone()
     * @param element
     * @returns {boolean}
     */
    this.isFone = function (element) {

        const fone = element.value;
        const number = fone.replace(/\D/g, '');
        const digitoControle = number.charAt(2);

        if (!settings.validaTelefone(number)) {
            return false;
        }

        return (digitoControle >= 2 && digitoControle <= 5);
    }

    /**
     * getCidades()
     * @param id
     * @param selectpicker
     * @returns {Promise<unknown>}
     */
    this.getCidades = (id, selectpicker) => {
        let params = {
            idEstado: $('#iEstado').val()
        };

        return new Promise((resolve, reject) => {
            $.ajax({
                method: 'GET',
                type : 'GET',
                url : '/api/pessoa/getCidadesPorEstado',
                data: params,
                beforeSend: function () {
                    jDialog.openLoading('Carregando....');
                },
                complete: function () {
                    jDialog.closeLoading();
                },
                success: function(response){
                    self.generateSelect(id, response.resultSet, selectpicker);
                    resolve(response);
                },
                error: function(response){
                    self.error(response);
                    reject(response);
                }
            });
        });
    };

    /**
     * Busca nivel de acesso
     * @param id
     * @param selectpicker
     * @returns {Promise<unknown>}
     */
    this.getNivelAcesso = function(id, selectpicker) {
        return new Promise((resolve, reject) => {
            $.ajax({
                method : 'GET',
                type   : 'GET',
                async   : false,
                url    : '/api/pessoa/getNivelAcesso',
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
     * Status
     * @param idPessoa
     */
    this.status = function(idPessoa) {
        $.ajax({
            method : 'GET',
            type   : 'GET',
            url:  '/api/pessoa/status',
            data: {
                idPessoa: idPessoa,
                status: ($('#status-'+ idPessoa +' input[type="checkbox"]').prop('checked')) ? 1 : 2
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

let _pessoa = new Pessoa();

$(document).ready(function() {
    $(document).on('click', '#formNovaPessoa #btnSalvar', function () {
        _pessoa.formValidateNovo();
    });

    $(document).on('change', '#formNovaPessoa #iCep', function () {
        if(this.value !== ''){
            _pessoa.getCep(this, 'formNovaPessoa');
        }
    });

    $(document).on('click', '#formEditarPessoa #btnEditar', function () {
        _pessoa.formValidateEditar();
    });

    $(document).on('change', '#formEditarPessoa #iCep', function () {
        if(this.value !== ''){
            _pessoa.getCep(this, 'formEditarPessoa');
        }
    });
});