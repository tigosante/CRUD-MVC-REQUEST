<div class="card">
    <div class="row">
        <div class="col-md-12">
            <form id="form_pesquisar_dados">
                <div class="card-body">
                    <h4 class="card-title">
                        Pesquisar dados
                    </h4>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control " id="name" name="name" placeholder="Nome">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="senha_user">E-mail</label>
                            <input type="text" class="form-control " id="email" name="email" placeholder="e-mail">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="acao" name="acao" value="get_dados">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-primary" onclick="get_dados('form_pesquisar_dados')">
                        <div class="" id="texto-button-login">Pesquisar</div>
                    </button>
                    <button type="button" class="btn btn-primary" onclick="page_novo_dado()">
                        <div class="" id="texto-button-login">Novo dado</div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="retorno_pesquisa"></div>

<script type="text/javascript" src="lib/modulo_tre/pesquisar_dados/js/treinamento.js"></script>