<div class="container-fluid d-flex justify-content-center vertical-center">
    <div class="col-md-4">
        <form id="form_login">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Login
                    </h4>
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
                </div>
                <input type="hidden" id="acao" name="acao" value="login_user">

                <button type="button" class="btn btn-primary" onclick="login_user()">
                    <div class="" id="texto-button-login">Entrar</div>
                </button>
                <button type="button" class="btn btn-primary" onclick="tela_novo_user()">
                    <div class="" id="texto-button-login">Criar conta</div>
                </button>
            </div>
        </form>
    </div>
</div>
