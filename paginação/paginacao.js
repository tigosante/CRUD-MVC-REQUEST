function usuarios() {
    $.ajax({
        type: "GET",
        url: "UsuarioController.php",
        data: "acao=usuarios",
        async: true,
        dataType: "json",
        success: function (retorno) {
            $("#conteudo").html(retorno);
        },
        beforeSend: function () {},
        complete: function () {},
        error: function (XMLHttpRequest, textStatus, errorThrown) {},
    });
}
