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
            min-height: calc(100vh - 100px);
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
            <form id="formCadastro" class="text-center"  method="post" novalidate>
                <div class="mb-3">
                    <input type="text" class="form-control" id="cep" name="cep" oninput="buscarCep()" placeholder="CEP"
                        required maxlength="8" />
                    <div class="invalid-feedback">CEP deve conter exatamente 8 números.</div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="Logradouro"
                        required />
                    <div class="invalid-feedback">Logradouro inválido!</div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" required
                        maxlength="6" />
                    <div class="invalid-feedback">Número inválido! Use até 6 dígitos numéricos.</div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="cpf" id="cpf" minlength="11" maxlength="14"
                        placeholder="CPF" required
                        onkeyup="
                let cpf = document.getElementById('cpf');
                cpf.value = cpf.value.replace(/\D/g,'')
                                     .replace(/(\d{3})(\d)/,'$1.$2')
                                     .replace(/(\d{3})(\d)/,'$1.$2')
                                     .replace(/(\d{3})(\d{1,2})$/,'$1-$2');" />
                    <div class="invalid-feedback">Por favor, insira um CPF válido.</div>
                </div>

                <div class="mb-3 dateNasc">
                    <input type="text" class="form-control" id="nascimento" name="nascimento"
                        placeholder="Data de Nascimento" onmouseover="(this.type='date')" onclick="(this.type='date')" onblur="if(this.value == 0){
                            (this.type='text');
                        }"
                        required />
                    <div class="invalid-feedback">Insira uma data de nascimento válida.(Min 18 anos)</div>
                </div>

                <div class="mb-4">
                    <input type="tel" class="form-control" id="telefone" name="telefone"
                        placeholder="Telefone: (xx) xxxxx-xxxx" required maxlength="11" />
                    <div class="invalid-feedback">Telefone deve conter 10 ou 11 números.</div>
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>

            <p href="#" class="esqueci mb-5">Já possui conta?<a href="index.php">
                    <br>Clique aqui</a></p>

        </div>
    </main>

</body>

<script src="js/bootstrap.min.js"></script>

<script>
     async function buscarCep() {
        const cep = document.getElementById('cep').value.trim();
        const resultado = document.getElementById('logradouro');

        if (cep.length === 8) {
            try {
                const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const dados = await res.json();

                if (dados.erro) throw new Error("CEP inválido.");

                resultado.value = dados.logradouro;
            } catch (error) {
                resultado.value = "";
                //alert("❌ Erro ao buscar o CEP: " + error.message);
            }
        }
    }

    function somenteNumeros(event) {
        const allowedKeys = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];
        if (!allowedKeys.includes(event.key) && !/^[0-9]$/.test(event.key)) {
            event.preventDefault();
        }
    }

    document.getElementById("cep").addEventListener("keydown", somenteNumeros);
    document.getElementById("numero").addEventListener("keydown", somenteNumeros);
    document.getElementById("cpf").addEventListener("keydown", somenteNumeros);
    document.getElementById("telefone").addEventListener("keydown", somenteNumeros);

    function validarLogradouro(texto) {
        const regex = /^[A-Za-zÀ-ÿ0-9\s\.\-]+$/;
        return regex.test(texto);
    }

    function validarDataNascimento(dataNascimentoStr) {
        if (!dataNascimentoStr) return false;

        const hoje = new Date();
        const nascimento = new Date(dataNascimentoStr);

        if (isNaN(nascimento.getTime()) || nascimento > hoje) return false;

        const idade = hoje.getFullYear() - nascimento.getFullYear();
        const m = hoje.getMonth() - nascimento.getMonth();
        const d = hoje.getDate() - nascimento.getDate();

        if (idade < 18 || (idade === 18 && (m < 0 || (m === 0 && d < 0)))) {
            return false;
        }

        return true;
    }

    function validarCampo(inputElem, condicaoValida) {
        if (condicaoValida) {
            inputElem.classList.remove("is-invalid");
            inputElem.classList.add("is-valid");
        } else {
            inputElem.classList.remove("is-valid");
            inputElem.classList.add("is-invalid");
        }
        return condicaoValida;
    }

    document.getElementById("formCadastro").addEventListener("submit", async function (e) {
        e.preventDefault();

        const cepElem = document.getElementById("cep");
        const logradouroElem = document.getElementById("logradouro");
        const numeroElem = document.getElementById("numero");
        const cpfElem = document.getElementById("cpf");
        const nascimentoElem = document.getElementById("nascimento");
        const telefoneElem = document.getElementById("telefone");

        const cep = cepElem.value.trim();
        const logradouro = logradouroElem.value.trim();
        const numero = numeroElem.value.trim();
        const cpf = cpfElem.value.trim();
        const nascimento = nascimentoElem.value;
        const telefone = telefoneElem.value.trim();

        // Validações com feedback
        const cepValido = validarCampo(cepElem, /^\d{8}$/.test(cep));
        const logradouroValido = validarCampo(logradouroElem, validarLogradouro(logradouro));
        const numeroValido = validarCampo(numeroElem, /^\d{1,6}$/.test(numero));
        const cpfValido = validarCampo(cpfElem, /^\d{11}$/.test(cpf));
        const nascimentoValido = validarCampo(nascimentoElem, validarDataNascimento(nascimento));
        const telefoneValido = validarCampo(telefoneElem, /^\d{10,11}$/.test(telefone));

        if (cpf !== "") {
            try {
                const response = await fetch('verificar_cpf.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `cpf=${encodeURIComponent(cpf)}`
                });

                const data = await response.json();
                if (data.existe) {
                    cpfElem.classList.add("is-invalid");
                    cpfElem.nextElementSibling.textContent = "O CPF já está em uso.";
                    cpfValido = false;
                } else {
                    cpfValido = true;
                }
            } catch (error) {
                console.error('Erro ao verificar o cpf:', error);
            }
        } 
        // Se algum campo for inválido, foca no primeiro inválido e não envia o formulário

        if (!cepValido) return cepElem.focus();
        if (!logradouroValido) return logradouroElem.focus();
        if (!numeroValido) return numeroElem.focus();
        if (!cpfValido) return cpfElem.focus();
        if (!nascimentoValido) return nascimentoElem.focus();
        if (!telefoneValido) return telefoneElem.focus();

        
        // Dados da etapa 2
        const dadosEtapa2 = { cep, logradouro, numero, cpf, nascimento, telefone };

        // Recupera dados da etapa 1
        const dadosEtapa1String = localStorage.getItem("dadosEtapa1");
        if (!dadosEtapa1String) {
            alert("Você precisa completar a primeira etapa do cadastro.");
            window.location.href = "cadastro1.php"; // ajuste conforme seu fluxo
            return;
        }

        let dadosCompletos;
        try {
            const dadosEtapa1 = JSON.parse(dadosEtapa1String);
            dadosCompletos = { ...dadosEtapa1, ...dadosEtapa2 };
        } catch (err) {
            console.error("Erro ao processar os dados da primeira etapa:", err);
            alert("Erro interno ao ler os dados da primeira etapa.");
            return;
        }

        const self = this;

        fetch('processaCadastro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ data: dadosCompletos }) // Enviando os dados como formulário
        })
        .then(response => {
            if (!response.ok) {
                // Lança erro para ser capturado no catch
                throw new Error(`HTTP status ${response.status}`);
            }
            return response.text(); // ou .json(), dependendo do que o PHP retorna
        })
        .then(result => {
            alert("Dados cadastrados com sucesso!");
            self.reset(); // Reseta o formulário

            // Remover a classe "is-valid" dos campos
            [cepElem, logradouroElem, numeroElem, cpfElem, nascimentoElem, telefoneElem].forEach(input => {
                input.classList.remove("is-valid");
            });

            // Limpa o armazenamento local
            localStorage.clear();

            // Redireciona para a página inicial
            window.location.href = "index.php";
        })
        .catch(error => {
            let errorMessage = "Erro desconhecido. Tente novamente mais tarde.";

            if (error.message.includes("403")) {
                errorMessage = "Erro 403: Acesso proibido.";
            } else if (error.message.includes("500")) {
                errorMessage = "Erro 500: Erro interno do servidor.";
            }

            alert(errorMessage);
            self.reset(); // Reseta o formulário

            // Remover a classe "is-valid" dos campos
            [cepElem, logradouroElem, numeroElem, cpfElem, nascimentoElem, telefoneElem].forEach(input => {
                input.classList.remove("is-valid");
            });

            // Limpa o armazenamento local
            localStorage.clear();

            // Redireciona para a página inicial
            window.location.href = "index.php";
        });
    });
</script>


</html>