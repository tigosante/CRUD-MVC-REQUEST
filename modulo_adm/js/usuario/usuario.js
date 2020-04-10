function pesquisar_usuario(form, event) {
    if (event) event.preventDefault();

    $.ajax({
        type: "GET",
        url: "modulo_adm/controller/manter_usuario/Usuario.controller.php",
        data: $("#" + form).serializeArray(),
        success: function (retorno) {
            $("#retorno").html(retorno);
            $("#resultado_consulta").show();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert_error("Erro, Desculpe!");
        },
    });
}
