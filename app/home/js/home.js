let checa_user = () => {
    const path = "#app/home/page/login_page";
    trocar_conteudo_pagina(path);
};

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

let novo_user = () => {
    $.ajax({
        method: "POST",
        url: "../../../../app/home/controller/HomeC.class.php",
        data: $("#form_novo_user").serializeArray(),
        async: true,
        dataType: "JSON",
        beforeSend: function () {},
        complete: function () {},
        success: function (retorno) {
            if (retorno.resultado) {
                alert("Usuário cadastrado");
                window.location.hash = "#app/home/page/home_page";
            } else novo_user();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {},
    });
};

let tela_inicial = () => {
    window.location.hash = "#app/home/page/home_page";
};

let tela_novo_user = () => {
    const path = "#app/home/page/novo_user";
    trocar_conteudo_pagina(path);
};
