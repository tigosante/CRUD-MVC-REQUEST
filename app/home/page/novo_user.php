<div class="container-fluid d-flex justify-content-center vertical-center">
    <div class="col-md-4">
        <form id="form_novo_user">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Novo Usuário
                    </h4>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="no_user">Nome completo</label>
                            <input type="text" class="form-control " id="no_user" name="no_user" placeholder="Nome completo" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="ds_email">E-mail</label>
                            <input type="text" class="form-control " id="ds_email" name="ds_email" placeholder="e-mail" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="senha_user">Senha</label>
                            <input type="password" class="form-control " id="senha_user" name="senha_user" placeholder="senha" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="conf_senha_user">Repita senha</label>
                            <input type="password" class="form-control " id="conf_senha_user" name="conf_senha_user" placeholder="Repita senha" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="acao" name="acao" value="cria_user">
                <button type="button" class="btn btn-primary" onclick="novo_user()">
                    <div class="" id="texto-button-login">Cadastrar</div>
                </button>
            </div>
        </form>
    </div>
</div>
