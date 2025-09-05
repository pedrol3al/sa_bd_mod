<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistema</title>

    <!-- Links do css, bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    
    <!-- Link do Notyf e a logo no topo do navegador -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="shortcut icon" href= "img/favicon-16x16.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="Login/index.css">

</head>

<body>
    <main class="container"> <!-- Corpo da página -->
        <div class="topoPag">
            <img class="imagemLogo" src="img/techinho.png" alt="Logo Techinho">
        </div>

        <div class="Formulario">
            <form method="POST" action="Login/login.php">
                <div class="informacoes">
                    <input name="email" id="email" type="email" placeholder="Digite seu email corporativo" class="form-control">
                    <input name="senha" id="senha" type="password" placeholder="Digite sua senha" class="form-control">
                </div>
                <div class="interacoes">
                    <button id="login" class="btn btn-primary" type="submit">Logar</button>
                    <a href="Login/esqueci_senha.php">Esqueci minha senha</a>
                </div>
                <div class="rodape">
                    <footer class="text-center mt-5"> <small>© 2025 Conserta Tech - Suporte: (47) 98472-8108</small>
                    </footer>
                </div>
            </form>
        </div>

        <!-- Links do javascript -->
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../Login/inicio.js"></script>
    </main>
</body>
</html>