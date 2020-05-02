function buscar() {
    $.ajax({
        type: "GET",
        url: "controller/controller.php",
        data: "acao=buscar_dados",
        async: true,
        dataType: "JSON",
        success: function (retorno) {
            document.getElementById("retorno").innerHTML = retorno;
        },
        error: (request, status, error) => {
            console.log("ERRO: Erro inesperado!");
        },
    });
}
