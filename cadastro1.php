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

        .esqueci {
            margin-top: 30px;
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
        <div class="form p-md-3">
            <br>
            <h1 class="text-center mb-3" style="font-family: madetommyM;">CADASTRO</h1>
            <form id="meuFormulario" class="text-center" method="post" novalidate>
                <div class="mb-3">
                    <input type="text" class="form-control" name="nome" id="nome" minlength="3" placeholder="Nome"
                        required />
                    <div class="invalid-feedback">Por favor, preencha o nome.</div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="sobrenome" id="sobrenome" minlength="3"
                        placeholder="Sobrenome" required />
                    <div class="invalid-feedback">Por favor, preencha o sobrenome.</div>
                </div>

                <div class="mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required />
                    <div class="invalid-feedback">Por favor, insira um email válido.</div>
                </div>

                <div class="mb-3">
                    <input type="email" class="form-control" name="confemail" id="confemail"
                        placeholder="Confirmar Email" required />
                    <div class="invalid-feedback">Os emails não coincidem.</div>
                </div>

                <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Senha"
                        required />
                    <div class="invalid-feedback">A senha deve ter pelo menos 6 caracteres.</div>
                </div>

                <div class="mb-4">
                    <input type="password" class="form-control" name="confpassword" id="confpassword"
                        placeholder="Confirmar Senha" required />
                    <div class="invalid-feedback">As senhas não coincidem.</div>
                </div>

                <button type="submit" class="btn btn-primary">------></button>
            </form>

            <p href="#" class="esqueci pb-5">Já possui conta?<a href="index.php">
                    <br>Clique aqui</a></p>

        </div>
    </main>

</body>
<script src="js/bootstrap.min.js"></script>
<script>
    document.getElementById("meuFormulario").addEventListener("submit", async function (e) {
        e.preventDefault();
        let formValido = true;

        const inputs = this.querySelectorAll("input");
        inputs.forEach((input) => input.classList.remove("is-invalid"));

        const nome = document.getElementById("nome");
        const sobrenome = document.getElementById("sobrenome");
        const email = document.getElementById("email");
        const confemail = document.getElementById("confemail");
        const password = document.getElementById("password");
        const confpassword = document.getElementById("confpassword");

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const letrasRegex = /^[A-Za-zÀ-ÿ\s]+$/;

        // Valida nome
        if (!letrasRegex.test(nome.value.trim())) {
            nome.classList.add("is-invalid");
            nome.nextElementSibling.textContent = "O nome deve conter apenas letras.";
            formValido = false;
        }

        // Valida sobrenome
        if (!letrasRegex.test(sobrenome.value.trim())) {
            sobrenome.classList.add("is-invalid");
            sobrenome.nextElementSibling.textContent = "O sobrenome deve conter apenas letras.";
            formValido = false;
        }

        // Valida e-mail
        if (!emailRegex.test(email.value.trim())) {
            email.classList.add("is-invalid");
            formValido = false;
        }

        // Confirmação de e-mail
        if (confemail.value.trim() !== "") {
            try {
                const response = await fetch('verificar_email.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `confemail=${encodeURIComponent(confemail.value.trim())}`
                });

                const data = await response.json();
                if (data.existe) {
                    confemail.classList.add("is-invalid");
                    email.classList.add("is-invalid");
                    confemail.nextElementSibling.textContent = "O email já está em uso.";
                    email.nextElementSibling.textContent = "";
                    formValido = false;
                } else {
                    formValido = true;
                }
            } catch (error) {
                console.error('Erro ao verificar o e-mail:', error);
            }
        } 
        if (confemail.value.trim() !== email.value.trim()) {
            confemail.classList.add("is-invalid");
            confemail.nextElementSibling.textContent = "Os emails não coincidem.";
            email.nextElementSibling.textContent = "";
            formValido = false;
        }
        

        // Senha
        if (password.value.length < 6) {
            password.classList.add("is-invalid");
            formValido = false;
        }

        // Confirmação de senha
        if (confpassword.value !== password.value) {
            confpassword.classList.add("is-invalid");
            formValido = false;
        }

        if (formValido) {
            const dadosCadastro = {
                nome: nome.value.trim(),
                sobrenome: sobrenome.value.trim(),
                email: email.value.trim(),
                password: password.value
            };

            localStorage.setItem("dadosEtapa1", JSON.stringify(dadosCadastro));

            // Redireciona para a etapa 2
            window.location.href = "cadastro2.php";
        }
    });
</script>



</html>