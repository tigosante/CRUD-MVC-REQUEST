let login_user = () => {
    $.ajax({
        method: "POST",
        url: "../../../../app/home/controller/HomeC.class.php",
        data: $("#form_login").serializeArray(),
        async: true,
        dataType: "JSON",
        beforeSend: function () {},
        complete: function () {},
        success: function (retorno) {
            if (retorno.resultado) tela_inicial();
            else novo_user();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {},
    });
};

let tela_inicial = () => {
    window.location.replace("#app/home/home");
};

let novo_user = () => {
    window.location.replace("#app/home/nove_user/nove_user");
};
