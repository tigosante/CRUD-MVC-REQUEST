<div class="card">
    <div class="row">
        <div class="col-md-12">
            <form id="form_login">
                <div class="card-body">
                    <h4 class="card-title">
                        Editar dado
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
                    <button type="button" class="btn btn-primary" onclick="update_dado()">
                        <div class="" id="texto-button-login">Editar</div>
                    </button>
                    <button type="button" class="btn btn-primary" onclick="page_pesquisa()">
                        <div class="" id="texto-button-login">Voltar</div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="lib/modulo_tre/pesquisar_dados/js/treinamento.js"></script>
