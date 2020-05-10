let login_user = () => {
    $.ajax({
        method: "POST",
        url: "../../../../app/home/login/controller/LoginC.class.php",
        data: $("#form_login").serializeArray(),
        dataType: "JSON",
        async: true,
        beforeSend: function () {
            // $("#carregar").html(
            //     "<img src='img/preloader.gif' style='width: 40px;' style='display: none; text-align: center;'> CARREGANDO"
            // );
        },
        complete: function () {
            // $("#carregar").html("");
        },
        success: function (retorno) {
            if (retorno.resultado) tela_inicial();
            else novo_user();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            // alert_error("Erro, Desculpe!");
        },
    });
};

let tela_inicial = () => {
    window.location = "#app/home/home";
};

let novo_user = () => {};
