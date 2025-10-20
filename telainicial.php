<?php
include("verifySession.php");
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

        .carousel-caption {
            position: absolute;
            right: 50%;
            bottom: 1.25rem;
            left: 0%;
            padding-top: 1.25rem;
            padding-bottom: 10rem;
            text-align: center;
        }

        .text-shadow{
            text-shadow: black 2px 2px 5px;
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
                            <a href="#" class="nav-link active" aria-current="page">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house mb-1" viewBox="0 0 16 16">
                                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                </svg>
                                Tela Inicial
                            </a>
                        </li>
                        <li>
                            <a href="meusveiculos.php" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front-fill mb-1" viewBox="0 0 16 16">
                                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z" />
                                </svg>
                                Meus Veículos
                            </a>
                        </li>
                        <li>
                            <a href="cadastrarnovo.php" class="nav-link link-dark">
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
                        <a class="d-flex align-items-center link-dark" type="button" href="perfil.php">
                            <img src="img/3364044.png" alt="" width="16" height="16" class="icones4 rounded-circle me-2">
                            <strong><?php echo ($_SESSION['nome_usuario']) . " " . ($_SESSION['sobrenome_usuario']); ?></strong>
                        </a>
                    </div>




                </div>
            </div>
        </div>

        <a href="telainicial.php"><img src="img/home_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="icones2 position-absolute top-0 end-0 bg-transparent" width="32px" height="32px" alt=""></a>

    </div>

    <img class="fotoperfil position-absolute top-0 start-50 translate-middle-x" src="img/account_circle_140dp_FFFFFF_FILL0_wght400_GRAD0_opsz48.png">
    <h6 class="usuario position-absolute top-0 start-50 translate-middle-x"><?php echo ($_SESSION['nome_usuario']) . " " . ($_SESSION['sobrenome_usuario']); ?></h6> <!--Os dados para este campo virão do PHP-->
    <a href="perfil.php" class="usuario2 position-absolute top-0 start-50 translate-middle-x">Editar Perfil</a>
    </div>
    <main class="container">
        <h5 class="mt-3">Gerenciar Veículos</h5>

        <!-- Os dados para este campo virão do PHP -->

        <div class="card mb-3 bg-secondary bg-gradient">
            <!-- carrossel -->
            <div class="text-center">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="img/comprar-1-0-mt-pacote-rgd_acd152e5f0.png" class="d-block w-100" alt="...">
                            <div class="carousel-caption">
                                <h5 class="text-shadow fs-2">Chevrolet Onix</h5>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="img/comprar-1-0-mt-pacote-rgd_acd152e5f0.png" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="img/comprar-1-0-mt-pacote-rgd_acd152e5f0.png" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <!-- carrossel -->
            <div class="card-body bg-light">
                <h5 class="card-title" id="carro1">Chevrolet Ônix</h5> <!-- Os dados para este campo virão do PHP -->
                <p class="card-text">Este é o seu carro.</p>
                <p class="card-text"><small class="text-muted">Última atualização há 3 minutos</small></p> <!-- Os dados para este campo virão do PHP -->
            </div>
        </div>



        <div class="alinhar text-center mt-3">
            <a button type="submit" class="btn btn-primary" href="meusveiculos.php">Meus Veículos</a>
            <button type="submit" class="btn btn-primary">Cadastrar Novo</button>
        </div>



    </main>
</body>
<script src="js/bootstrap.min.js"></script>



</html>