let EsqueciSenha = function() {

    let self  = this;

    this.formValidate = () => {

        let form = $("#formEsqueciSenha");

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
                }
            },
            messages: {
                login: {
                    required: "Campo obrigatório",
                    minlength : "Informe no mínimo 5 caracteres",
                    maxlength : "Informe no máximo 85 caracteres"
                }
            },
            submitHandler: () => {
                self.getEsqueciSenha();
            }
        });
    };

    this.getEsqueciSenha = () => {
        return new Promise((resolve, reject) => {
            $.ajax({
                method : 'GET',
                type   : 'GET',
                url    : '/api/login/getEsqueciSenha',
                data   : $('#formEsqueciSenha').serializeArray(),
                beforeSend: function () {
                    console.log('Carregando....');
                },
                complete: function () {
                    console.log('Complete....');
                },
                success: function(response){
                    resolve(response);
                },
                error: function(response){
                    self.error(response);
                    reject(response);
                }
            });
        });
    };

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

let _esqueciSenha = new EsqueciSenha();

$(document).ready(function() {
    $('#continuar').on('click', function () {
        _esqueciSenha.formValidate();
    });
});