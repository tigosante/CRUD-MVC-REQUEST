<?php
//  criar metódo de verificação de usuário.

$user = true;
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="app/assets/css/boostrap/boostrap.4.4.0.min.css">

    <script src="app/assets/js/jquery/jquery.3.5.min.js"></script>
    <script src="app/assets/js/bootstrap/bootstrap.4.4.0.min.js"></script>
    <script src="app/assets/js/popper/popper.min.js"></script>

    <script type="text/javascript" src="app/assets/js/default_application/default_application.js"></script>
    <script type="text/javascript" src="lib/home/js/home.js"></script>

    <title>Plataforma de Treinamento</title>

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

    <div class="container-fluid" id="conteudo_plataforma"></div>

    <script>
    checa_user();
    </script>

</body>

</html>