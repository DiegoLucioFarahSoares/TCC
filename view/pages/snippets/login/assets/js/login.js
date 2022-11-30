let Login = function() {

    // var url = 'api/index.php';
    let self  = this;

    this.formValidate = () => {

        let form = $("#formLogin");

        form.validate({
            onkeyup: function (input) {
                if (/^\s*$/.test(input.value)) {
                    input.value = input.value.trim();
                }
            },
            rules: {
                login: {
                    required: true,
                    minlength : 5,
                    maxlength : 85
                },
                senha: {
                    required: true
                }
            },
            messages: {
                login: {
                    required: "Campo obrigatório",
                    minlength : "Informe no mínimo 5 caracteres",
                    maxlength : "Informe no máximo 85 caracteres"
                },
                senha: {
                    required: "Campo obrigatório"
                }
            },
            submitHandler: () => {
                self.findLogin();
            }
        });
    };

    this.findLogin = function () {

        const params = {
            login: $('#login').val(),
            senha: $('#senha').val()
        }

        $.ajax({
            method : 'POST',
            type   : 'POST',
            url    : '/api/login/findLogin',
            data   : params,
            beforeSend: function () {
                jDialog.openLoading('Carregando....');
            },
            complete: function () {
                jDialog.closeLoading();
            },
            success: function(response) {
                if(response.status) {
                    let dados = response.resultSet;

                    if(dados) {
                        window.document.location.href = "/painel-gestao";
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Login/Senha Inválidos'
                        });
                    }
                }
            },
            error: function(response){
                self.error(response);
            }
        });
    }

    this.error = (response) => {
        try {

            let retorno = JSON.parse(response.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: retorno.message
            });

        } catch (e) {
            self.defaultMessageError();
        }
    };

    this.defaultMessageError = () => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não é possível realizar esta ação!'
        });
    };
};

let _login = new Login();

$(document).ready(function() {
    $('#entrar').on('click', function () {
        _login.formValidate();
    });
});