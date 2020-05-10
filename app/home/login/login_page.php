<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="../../app/core/lib/js/jquery.3.5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <title>Login</title>

    <style>
        .vertical-center {
            min-height: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>

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
                                <input type="text" class="form-control " id="ds_email" name="ds_email" placeholder="e-mail">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="senha_user">Senha</label>
                                <input type="password" class="form-control " id="senha_user" name="senha_user" placeholder="senha">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="acao" name="acao" value="login_user">
                    <button type="button" class="btn btn-primary" onclick="login_user()">
                        <div id="preloader"></div>
                        <div class="" id="texto-button-login">Entrar</div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="./app/home/login/js/login.js"></script>
</body>

</html>
