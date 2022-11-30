$(document).ready(function() {
    $(".exibir-detalhes").show();
    $(".exibir-sala-aula").hide();

    $(document).on('click', '#salaAula', function () {
        $(".exibir-detalhes").hide();
        $(".exibir-sala-aula").show();
    });

    $(document).on('click', '#fechar', function () {
        $(".exibir-detalhes").show();
        $(".exibir-sala-aula").hide();
    });
});