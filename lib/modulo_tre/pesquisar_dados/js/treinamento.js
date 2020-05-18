/**
 * Caminhos para as páginas do módulo.
 */

const url_controller =
    "lib/modulo_tre/pesquisar_dados/controller/TreinamentoC.class.php";

/**
 * Caminhos para as páginas do módulo.
 */

const pg_pesquisa = "#modulo_tre/pesquisar_dados/page/pesquisar_dados";
const pg_novo_dado = "#modulo_tre/pesquisar_dados/page/criar_dados";
const pg_editar_dados = "#modulo_tre/pesquisar_dados/page/editar_dados";

/**
 * Função que direciona para a página de pesquisa.
 */
const page_pesquisa = () => {
    window.location = pg_pesquisa;
};

/**
 * Função que direciona para a página de casdastro.
 */
const page_novo_dado = () => {
    window.location = pg_novo_dado;
};

/**
 * Função que direciona para a página de editação.
 */
const page_editar_dados = () => {
    window.location = pg_editar_dados;
};

/**
 * Função que busca dos dados no banco de dados e exibe para o usuário.
 */
let get_dados = (from) => {
    $.ajax({
        method: "GET",
        url: url_controller,
        data: document.getElementById(from).serializearray(),
        async: true,
        dataType: "JSON",
        success: function (dados) {
            document.getElementById("retorno_pesquisa").innerHTML = dados;
        },
        beforeSend: function () {
            // Essa implementação ainda não foi feita.
        },
        complete: function () {
            // Essa implementação ainda não foi feita.
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("Erro ao buscar dados.");
        },
    });
};

/**
 * Função que atualiza um determinado dado no banco de dados.
 */
let update_dado = (from) => {
    $.ajax({
        method: "POST",
        url: url_controller,
        data: from.serializearray(),
        async: true,
        dataType: "JSON",
        success: function (ratorno) {
            if (ratorno.resultado) {
                alert("Dado atualizado com sucesso!");
                page_pesquisa();
            } else {
                alert("Erro ao atualizar o dado.");
            }
        },
        beforeSend: function () {
            // Essa implementação ainda não foi feita.
        },
        complete: function () {
            // Essa implementação ainda não foi feita.
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("Erro ao atualizar o dado.");
        },
    });
};

/**
 * Função que cadastra um determinado dado no banco de dados.
 */
let set_novo_dado = (from) => {
    $.ajax({
        method: "POST",
        url: url_controller,
        data: from.serializearray(),
        async: true,
        dataType: "JSON",
        success: function (ratorno) {
            if (ratorno.resultado) {
                alert("Dado cadastrado com sucesso!");
                page_pesquisa();
            } else {
                alert("Erro ao atualizar o dado.");
            }
        },
        beforeSend: function () {
            // Essa implementação ainda não foi feita.
        },
        complete: function () {
            // Essa implementação ainda não foi feita.
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("Erro ao cadastrar o dado.");
        },
    });
};

/**
 * Função que deleta determinado dado do banco de dados.
 */
let delete_dado = (from) => {
    $.ajax({
        method: "POST",
        url: url_controller,
        data: from.serializearray(),
        async: true,
        dataType: "JSON",
        success: function (ratorno) {
            if (ratorno.resultado) {
                alert("Dado deletado com sucesso!");
                page_pesquisa();
            } else {
                alert("Erro ao atualizar o dado.");
            }
        },
        beforeSend: function () {
            // Essa implementação ainda não foi feita.
        },
        complete: function () {
            // Essa implementação ainda não foi feita.
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("Erro ao cadastrar o dado.");
        },
    });
};
