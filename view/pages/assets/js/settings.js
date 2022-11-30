class settings {

    static isEmpty(str){
        return (!str || /^\s*$/.test(str));
    }

    static hasError(response) {
        if('ok' in response) {
            return new Error(response.statusText)
        }

        if (!response.status) {

            let message = 'message' in response ? response.message : 'Ocorreu um erro durante a requisição';

            return new Error(message);
        }

        return response;
    }

    static error(response){
        try {

            Loader.closeLoading();

            let retorno;
            let msg = '';

            if(typeof response === 'object'){

                if(response.hasOwnProperty('message') || response.hasOwnProperty('mensagem')) {
                    msg = response.mensagem ? response.mensagem : response.message;
                }
                else {
                    retorno = JSON.parse(response.responseText);
                    msg = retorno.message;
                }
            }

            Swal.fire({ icon: 'error', title: 'Oops...', html: msg });
        }
        catch (e) {
            Swal.fire({ icon: 'error', title: 'Oops...', html: '<p>Ocorreu um erro durante a requisição, tente novamente mais tarde.</p>' });
        }
    }

    static diffYears(dateOut, dateOld = new Date()){
        let date1 = moment(dateOut);
        let date2 = moment(dateOld);
        return date2.diff(date1, 'years', true);
    }

    static isEmailValid(value){
        const re = /^(([^<>()[\]\\#.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(value);
    }

    static rafAsync(){
        return new Promise(resolve => {
            requestAnimationFrame(resolve);
        });
    }

    static checkElement(selector) {
        if (document.querySelector(selector) === null) {
            return this.rafAsync().then(() => this.checkElement(selector));
        } else {
            return Promise.resolve(true);
        }
    }

    static toDescription(name) {
        return Object.freeze({ toString: () => name });
    }

    static validaTelefone(fone){

        // retira todos os caracteres menos os numeros
        let telefone = fone.replace(/\D/g,'');

        // verifica se tem a qtde de numero correto
        if(!(telefone.length >= 10 && telefone.length <= 11)) {
            return false;
        }

        // Se tiver 11 caracteres, verificar se começa com 9 o celular
        if (telefone.length === 11 && parseInt(telefone.substring(2, 3)) !== 9) {
            return false;
        }

        //verifica se não é nenhum numero digitado errado (propositalmente)
        for(let n = 0; n < 10; n++){

            if(telefone === new Array(11).join(n) || telefone === new Array(12).join(n)) {
                return false;
            }
        }

        let codigosDDD = [11, 12, 13, 14, 15, 16, 17, 18, 19,
            21, 22, 24, 27, 28, 31, 32, 33, 34,
            35, 37, 38, 41, 42, 43, 44, 45, 46,
            47, 48, 49, 51, 53, 54, 55, 61, 62,
            64, 63, 65, 66, 67, 68, 69, 71, 73,
            74, 75, 77, 79, 81, 82, 83, 84, 85,
            86, 87, 88, 89, 91, 92, 93, 94, 95,
            96, 97, 98, 99];

        //verifica se o DDD é valido
        if(codigosDDD.indexOf(parseInt(telefone.substring(0, 2))) === -1) {
            return false;
        }

        if (telefone.length === 10 && [2, 3, 4, 5, 7].indexOf(parseInt(telefone.substring(2, 3))) === -1) {
            return false;
        }

        return true;
    }

    static cpf(cpf){

        cpf = cpf.replace(/[^\d]+/g, '');

        if (cpf.length !== 11 ||
            cpf === "00000000000" ||
            cpf === "11111111111" ||
            cpf === "22222222222" ||
            cpf === "33333333333" ||
            cpf === "44444444444" ||
            cpf === "55555555555" ||
            cpf === "66666666666" ||
            cpf === "77777777777" ||
            cpf === "88888888888" ||
            cpf === "99999999999") {
            return false;
        }

        let add = 0;

        for (let i = 0; i < 9; i++) {
            add += parseInt(cpf.charAt(i)) * (10 - i);
        }

        let rev = 11 - add % 11;

        if (rev === 10 || rev === 11) {
            rev = 0;
        }

        if (rev !== parseInt(cpf.charAt(9))) {
            return false;
        }

        add = 0;

        for (let i = 0; i < 10; i++) {
            add += parseInt(cpf.charAt(i)) * (11 - i);
        }

        rev = 11 - add % 11;

        if (rev === 10 || rev === 11) {
            rev = 0;
        }

        if (rev !== parseInt(cpf.charAt(10))) {
            return false;
        }

        return true;
    }
}