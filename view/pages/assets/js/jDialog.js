var JDialog = function()
{

    var vm = this;

    this.item = '';

    /**
     * ADICIONA UM LOADING NA TELA
     * @param message
     */
    this.openLoading = function(message)
    {
        vm.closeLoading();
        vm.fundo('Loading');
        var html = '<div id="JLoading" style="' +
            'max-width: 400px;' +
            'width: auto;' +
            'height: 80px;' +
            'position: fixed;' +
            'background: #ffffff;' +
            'border: 1px solid #dfdfdf;' +
            'border-radius: 5px;' +
            'top: 0;' +
            'right: 0;' +
            'left: 0;' +
            'bottom: 0;' +
            'margin: auto;' +
            'padding: 25px;' +
            'z-index: 999999">' +
            '<p><span class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size: 30px; vertical-align: middle"></span> <span style="vertical-align: middle">'+ message +'</span></p>' +
            '</div>';


        $('body').append(html);

    };

    /**
     * REMOVE O LOADING DA TELA
     */
    this.closeLoading = function()
    {
        $('#JDialogFundoLoading').remove();
        $('#JLoading').remove();
    };

    /**
     * RESPONS?VEL POR ABRIR A DIALOG
     * @param content
     * @param width
     * @param height
     */
    this.openDialog = function(content, width, height, item)
    {

        vm.item = item;

        if(item < 2 && item != '' || item < 0 && item != ''){
            console.error('O Numero da Dialog deve ser maior que 1(um)!');
            return false;
        }

        vm.closeDialog(item);
        vm.fundo('');

        if(!width) width = '600px';
        if(!height || height == '') height = 'auto';
        if(item == '') item = '';
        if(item == undefined) item = '';
        if(item == null) item = '';
        if(!item) item = '';

        if(height === 'auto' && $('#JDialog'+item+' div').height() > $('#JDialog'+item).height()){
            height = $('#JDialog'+item+' div').height();
        }

        var zIndex = 99999 + parseInt(item == '' ? 0 : item);

        var html = '<div id="JDialog'+ item +'" style="' +
            'width: '+ width +';' +
            'height: ' + height + ';' +
            'max-height: 100% !important;' +
            // 'overflow: auto;' +
            'position: fixed;' +
            'background: #ffffff;' +
            'top: 0;' +
            'right: 0;' +
            'left: 0;' +
            'bottom: 0;' +
            'margin: auto;' +
            'box-shadow: 0px 0px 40px #888888;' +
            'z-index: '+ zIndex.toString() +'"><div>' + content + '</div></div>';

        $('body').append(html);
        $('#JDialog'+ item).css({ height: $('#JDialog'+ item +' div').height()});
        $('body').css({'overflow': 'hidden'});

        vm.insereBlur(item);

    };

    /**
     * RESPONS?VEL POR FECHAR A DIALOG
     */
    this.closeDialog = function(item)
    {
        if(!item || item == '') item = '';
        if(item == '') $('body').css({'overflow': 'auto'});
        $('body').css({'overflow': 'auto'});
        $('#JDialogFundo').remove();
        $('#JDialog' + item).remove();

        vm.removeBlur(item);


    };

    /**
     * @param complemento
     */
    this.fundo = function(complemento)
    {
        var html = '<div id="JDialogFundo' + complemento + '" style="' +
            'top: 0; ' +
            'width: 100%; ' +
            'height: 100%;' +
            'position: fixed;' +
            'background: #000000;' +
            'opacity: 0.3;' +
            'z-index: 9998"></div>';

        $('body').append(html);
    };
    this.removeFundo = (elemento)=>{
        $('#JDialogFundo'+elemento).remove();
    }

    /**
     * FUN??O RECURSIVA RESPONSAVEL POR INSERIR BLUR NA TELA
     * @param item
     */
    this.insereBlur = function(item)
    {

        var blur = item == '' ? 'N' : 'S';
        item = item == '' ? '' : parseInt(item) - 1;
        item = item == 0 ? '' : item == 1 ? '' : item;

        if(blur == 'S'){
            $('#JDialog' + item).css(
                {
                    'filter'        : 'blur(2px)',
                    'pointerEvents' : 'none'
                });

            vm.insereBlur(item);
        }
    };


    /**
     * FUN??O RECURSIVA RESPONSAVEL POR REMOVER O BLUR
     * @param item
     */
    this.removeBlur = function(item)
    {

        item = item == '' ? ''  : parseInt(item) - 1;
        item = item == 0 ? ''   : item == 1 ? '' : item;

        if($('#JDialog'+ item).length == 1){
            $('#JDialog'+ item).css({
                'filter'        : 'blur(0px)',
                'pointerEvents' : 'auto'
            });
        } else {
            if(item != ''){
                vm.removeBlur(item);
            }

        }

    };


    this.updatePosition = function(item)
    {
        if(item == '') item = '';
        if(item == undefined) item = '';
        if(item == null) item = '';
        if(!item) item = '';

        if(window.innerHeight < $('#JDialog'+ item + ' div:first').height()){
            $('#JDialog'+ item + ' div:first').css({ maxHeight: (window.innerHeight - 10)+'px', overflow: 'auto'});
        }

        // $('#JDialog'+ item + ' div:first').css({ maxHeight: '450px', overflow: 'auto'});
        $('#JDialog'+ item).css({ height: $('#JDialog'+ item +' div').height()});

    };


    this.init = function()
    {
        console.warn('JDIALOG NECESSITA DO BOOTSTRAP E FONTAWESOME');
    };

    vm.init();



    this.alert = function(mensagem, bg, time) {

        time = !time ? 4000 : parseInt(time) * 1000;
        var background = !bg ? 'success' : bg;
        var titulo = 'Sucesso';
        switch (bg){
            case 'success' :
                titulo = 'Sucesso!';
                break;
            case 'Info' :
                titulo = 'Informativo';
                break;
            case 'warning' :
                titulo = 'Aten��o!';
                break;
            case 'danger' :
                titulo = 'Ops!';
                break;
        }

        var html = '<div id="jDialogAlert" style="position: fixed; top: 10px; right: 10px; z-index: 999999" class="col-xs-12 col-sm-4 col-md-4">' +
            '<div class="alert alert-'+background+'">' +
            '<h4><strong>'+titulo+'</strong></h4><hr style="margin: 8px;" />' +
            '<p>'+mensagem+'</p>' +
            '</div>' +
            '</div>';

        $('body').append(html);

        setTimeout(function(){
            $('#jDialogAlert').remove();
        }, time);
    }

};

var jDialog = new JDialog();