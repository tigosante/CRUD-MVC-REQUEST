function getUsuario(form, e) {
    $.ajax({
        type: "GET",
        url: "MVC/controller/Controller.class.php",
        data: $("#" + form).serializeArray(),
        success: function (retorno) {
            $("#conteudo_atribuicao").html(retorno);
            $("#retorno_atribuicao").show("speed,callback");
        },
        beforeSend: function () {
            showPreloader();
        },
        complete: function () {
            hiddenPreloader();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert_error("Erro, Desculpe.");
        },
    });

    e.preventDefault();
    return false;
}
