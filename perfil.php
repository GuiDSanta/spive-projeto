<?php

include("verifySession.php");
include("conexaodb.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoEmail = $_POST['email'];
    $usuarioId = $_SESSION['id_usuario'];

    $login = $novoEmail;
    // Verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM usuario WHERE email = ?");

    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result_id = $stmt->get_result();
    $total = $result_id->num_rows;
    if ($total > 0) {
        // Email já cadastrado
        echo "<script> alert('Email já cadastrado');</script>";
    } 

    // Atualiza o email no banco de dados
    $sql = "UPDATE usuario SET email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $novoEmail, $usuarioId);

    if ($stmt->execute()) {

        // Atualiza o email na sessão
        $_SESSION['email_usuario'] = $novoEmail;
        echo "<script>
        window.onload = function() {
            document.getElementById('alertabom').style.visibility = 'visible';
            setTimeout(function() {
                document.getElementById('alertabom').style.visibility = 'hidden';
            }, 3000);
        };
        </script>";
    } else {
        echo "<script>
        window.onload = function() {
            document.getElementById('alertaerro').style.visibility = 'visible';
            setTimeout(function() {
                document.getElementById('alertaerro').style.visibility = 'hidden';
            }, 3000);
        };
        </script>";
    }

    $stmt->close();
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
            background-color: rgb(240, 240, 240);
        }

        body {
            background-color: rgb(240, 240, 240);
            margin: 0;
        }

        .LogoSpive {
            height: 220px;
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

        .esqueci {
            margin-top: 130px;
        }

        .icones {
            width: 32px;
            height: 32px;
            margin: 10px;
        }

        .icones2 {
            width: 36px;
            height: 32px;
            margin: 8px;
        }

        .icones3 {
            width: 80px;
            height: 80px;
            margin: 8px;
            margin-top: 35px;
        }

        .icones4 {
            width: 32px;
            height: 32px;
        }

        .fotoperfil {
            width: 140px;
            height: 140px;
            margin-top: 10px;
        }

        .usuario {
            color: #e9e9e9ff;
            margin-top: 160px;
        }

        .usuario2 {
            color: #437ECA;
            ;
            margin-top: 180px;
        }

        .carros {
            width: 350px;
            height: 202px;
            border-radius: 6px;
            border: 1px solid black;
        }

        .jeferson {
            margin-top: 10px;
            margin-left: 250px;
        }

        .imgcarro {
            width: 246px;
            height: 136px;
        }

        img {
            width: 256px;
            height: 226px;
        }

        hr {
            color: #000000ff;
        }

        .carros {
            max-width: 600px;
            max-height: 400px;
            width: 70%;
            height: auto;
            border: none;
            margin: 2px;
        }

        input {
            background-color: transparent;
            border-radius: 0px;
            border: none;
            border-bottom: solid 1px black;
            max-width: 360px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="LogoSpive">
        <div class="row">

            <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><img src="img/menu_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="icones position-absolute top-0 start-0 bg-transparent" width="32px" height="32px" alt=""></a>
            <div class="offcanvas offcanvas-start" style="max-width: 400px;
                width: 70%;" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <img src="img/Spive (2048 x 2048 px) (1).png" class="icones3" width="32px" height="32px" alt="">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">MENU SPIVE</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <hr>
                <div class="offcanvas-body ajustamento">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="telainicial.php" class="nav-link link-dark" aria-current="page">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house mb-1" viewBox="0 0 16 16">
                                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                </svg>
                                Tela Inicial
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front-fill mb-1" viewBox="0 0 16 16">
                                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z" />
                                </svg>
                                Meus Veículos
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle mb-1" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                                Cadastrar Veículo
                            </a>
                        </li>
                        <li>
                            <a href="saibamais.php" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-right" viewBox="0 0 16 16">
                                    <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
                                </svg>
                                Saiba Mais
                            </a>
                        </li>
                        <li>
                            <a href="logout.php" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left mb-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                </svg>
                                Sair
                            </a>
                        </li>
                    </ul>
                    <hr>


                    <div>
                        <a class="d-flex align-items-center link-dark" id="dropdownUser21" data-bs-toggle="dropdown" aria-expanded="false" type="button" href="#">
                            <img src="img/3364044.png" alt="" width="16" height="16" class="icones4 rounded-circle me-2">
                            <strong><?php echo $_SESSION['nome_usuario']; ?></strong>
                        </a>
                    </div>




                </div>
            </div>
        </div>
        <a href="telainicial.php"><img src="img/home_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="icones2 position-absolute top-0 end-0 bg-transparent" width="32px" height="32px" alt=""></a>

    </div>

    <a class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <img class="fotoperfil position-absolute top-0 start-50 translate-middle-x" src="img/account_circle_140dp_FFFFFF_FILL0_wght400_GRAD0_opsz48.png" id="fotoperfil" alt="Foto de Perfil">
    </a>

    <nav class="navbar navbar-light" style="margin-top: -30px;top: -30px; background-color: #16427F;">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <div class="justify-content-evenly d-flex pb-3 pt-3">
                        <a href="" class="text-light" style="text-decoration: underline; text-decoration-color: gray">Tirar Foto</a>
                        <a href="" class="text-light" style="text-decoration: underline; text-decoration-color: gray">Escolher na galeria</a>
                        <a href="" class="text-light" style="text-decoration: underline; text-decoration-color: gray" onclick="retirar()">Remover</a>
                    </div>
                    <div class="justify-content-center d-flex pb-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" style="background-color: #4774B3;">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <h5 class="usuario position-absolute top-0 start-50 translate-middle-x"><?php echo ($_SESSION['nome_usuario']); ?></h5> <!--Os dados para este campo virão do PHP-->
    </div>
    <div class="m-2">
        <h5>Editar Perfil</h5>
        <br>
    </div>
    <form class="m-3 d-flex flex-column" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" disabled placeholder="<?php echo ($_SESSION['nome_usuario']); ?>">
        <br>
        <label for="nome">Sobrenome:</label>
        <input type="text" name="sobrenome" id="sobrenome" disabled placeholder="<?php echo ($_SESSION['sobrenome_usuario']); ?>">
        <br>
        <label for="nome">Email:</label>
        <input type="email" name="email" id="email" placeholder="<?php echo ($_SESSION['email_usuario']); ?>">
        <br>
        <div class=text-center>
            <button class="btn btn-primary" type="submit" style="background-color: #16427F;">Salvar</button>
        </div>
    </form>


    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>

        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>

    <br>

    <div class="text-center d-flex justify-content-center" style="visibility: hidden" id="alertabom">
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>
                Alterações salvas!
            </div>
        </div>
    </div>

    <div class="alert alert-danger d-flex align-items-center" role="alert" style="visibility: hidden" id="alertaerro">
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                As alterações não foram salvas! Tente novamente.
            </div>
        </div>
    </div>

    </main>
</body>
<script src="js/bootstrap.min.js"></script>
<script>
    function salvar() {
        document.getElementById("alerta").style.visibility = "visible";
    }

    function retirar() {
        document.getElementById("fotoperfil").src = "img/3364044.png";
    }
</script>

</html>