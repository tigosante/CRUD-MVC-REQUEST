$(document).ready(function (e) {
    if (window.location.hash) {
        const path = window.location.hash.substring(1);
        $("#conteudo_plataforma").load(path + ".php");
    }

    jQuery(window).on("hashchange", function (e) {
        const path = window.location.hash.substring(1);
        $("#conteudo_plataforma").load(path + ".php");
    });

    $(".link").click(function (e) {
        trocar_conteudo_pagina($(this).attr("link"));
    });
});

function trocar_conteudo_pagina(path) {
    window.location.hash = path;
}
