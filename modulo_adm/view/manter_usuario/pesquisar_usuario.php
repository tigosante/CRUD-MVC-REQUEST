<?php
error_reporting(E_ALL);

$autoPesquisar = 'n';
if (key_exists('ap', $_GET)) {
    $parametros = explode('.php', $_GET['ap']);
    $autoPesquisar = (isset($parametros[0]) ? $parametros[0] : 'n');
}
?>

<div class="col-md-12">
    <form id="formulario_pesquisar_usuario">
        <div class="card">
            <div class="header">
                <h4 class="title">Pesquisar Usuário</h4>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Módulo</label>
                            <select class="form-control" id="cd_modulo" name="cd_modulo" onchange="perfil_pesquisa_listar();"></select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Perfil</label>
                            <select class="form-control" id="cd_perfil" name="cd_perfil"></select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Matrícula</label>
                            <input type="text" class="form-control" id="nr_matricula" name="nr_matricula" maxlength="8" onkeypress="return somente_numero()" onfocus="(this.value='')">
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-header card-botoes">
                <div>
                    <input type="hidden" id="acao" name="acao" value="getUsuario">
                    <button type="button" class="btn btn-light" id="usuarioPesquisar" onclick="pesquisar_usuario('formulario_pesquisar_usuario', event)">Usuários Cadastrados</button>
                </div>
                <div></div>
            </div>
        </div>
    </form>
</div>

<div id="resultado_consulta" style="display:none;">
    <div class='col-md-12'>
        <div class='card'>
            <div class='header'>
                <h4 class='title'>Resultado da consulta</h4>
            </div>
            <div class='content table-full-width'>
                <div id="retorno"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="./modulo_adm/js/modulo/modulo.js"></script>
<script type="text/javascript" src="./modulo_adm/js/usuario/usuario.js"></script>

<script>
    combo_modulos("cd_modulo", "");
</script>

<?php if ($autoPesquisar == 's') {  ?>
    <script>
        carregarFiltrosConsulta("<?= $_SESSION['stringParametros']; ?>", "usuarioPesquisar");
    </script>
<?php } ?>
