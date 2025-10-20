<?php
$erroMsg = "";
// Inicia a sessão
session_start();
if(!empty($_SESSION["erro_login"])){
    $erroMsg = $_SESSION["erro_login"];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spive</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="img/Spive (2048 x 2048 px) (1).png">
    <style>
        @font-face {
            font-family: 'madetommy';
            /* Nome que vai usar no CSS */
            src: url('font/madetommyfontR.otf') format('opentype');
            /* ou italic */
        }

        @font-face {
            font-family: 'madetommyM';
            /* Nome que vai usar no CSS */
            src: url('font/madetommyfontM.otf') format('opentype');
            /* ou italic */
        }


        .container {
            font-family: madetommy, sans-serif;
            background-color: white;
            padding-bottom: 9vh;
        }

        body {
            background-color: rgb(240, 240, 240);
            margin: 0;
        }

        .LogoSpive {
            height: 160px;
            background-color: #16427F;
        }

        .form {
            height: 675px;
            align-items: center;
            text-align: center;
            display: flex;
            flex-direction: column;
        }

        .form input {
            height: 48px;
            width: 304px;
            border: solid 2px rgb(102, 102, 102);
            box-shadow: 2px 2px 3px 0px grey;
        }

        .btn {
            width: 144px;
            height: 40px;
            background-color: #16427F;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.25s;
        }

        .btn:active {
            background-color: #1c519c;
            transition: 0.25s;
            transform: scale(1.1);
        }

        h1 {
            font-size: 40px;
            color: #16427F;
        }

        a {
            color: #437ECA;
            text-decoration: none;
        }

    </style>
</head>

<body>
    <div class="LogoSpive">
        <div class="text-center">
            <img src="img/Spive (2048 x 2048 px) (1).png" alt="" class="" width="180px" height="180px">
        </div>
    </div>
    <main class="container">

        <div class="form pb-5">
            <br>
            <h5 class="text-danger"> <?php echo $erroMsg; ?></h5>
            <h1 class="text-center mb-3 mt-5" style="font-family: madetommyM;">Esqueceu a senha?</h1>
            <br>
            <br>
            <form action="loginteste.php" class="text-center mb-5" method="post">
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Email" required />
                </div>
                <br>
                <br>
                <br>

                <button type="submit" class="btn btn-primary">
                    Confirmar
                </button>
                <br><br>
                <a href="saibamais.php" class='text-secondary fs-6 mt-0 text-decoration-underline'>Saiba mais</a>


            </form>
            <p class="">Não possui uma conta? <a href="cadastro1.php" class="esqueci">Clique aqui</a></p>
        </div>
    </main>

</body>
<script src="js/bootstrap.min.js"></script>

</html> 

