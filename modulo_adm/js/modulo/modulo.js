function combo_modulos(id_campo, valor) {
    $.ajax({
        type: "GET",
        url: "modulo_adm/controller/manter_modulos/Modulo.controller.php",
        data: "acao=getComboModulos",
        success: function (retorno) {
            retorno = JSON.parse(retorno);

            var options = "<option value=''>Selecione...</option>";

            $.each(retorno, function (index, value) {
                options += `<option value='${value["CD_MODULO"]}'>${value["DS_MODULO"]}</option>`;
            });

            $("#" + id_campo).html(options);
            $("#" + id_campo).val(valor);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert_error("Erro, Desculpe!");
        },
    });
}
