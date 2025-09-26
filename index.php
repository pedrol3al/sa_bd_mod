<?php
// Inicia a sessão imediatamente
session_start();

// Guarda a mensagem antes de limpar variáveis temporárias
$mensagem = $_SESSION['msg'] ?? null;

// Transfere mensagens de sucesso para exibição
if (isset($_SESSION['mensagem_sucesso'])) {
    $_SESSION['mensagem'] = $_SESSION['mensagem_sucesso'];
    $_SESSION['tipo_mensagem'] = $_SESSION['tipo_mensagem_sucesso'];
    
    unset($_SESSION['mensagem_sucesso'], $_SESSION['tipo_mensagem_sucesso']);
}

// Se necessário, limpar variáveis de login antigas
unset($_SESSION['usuario']);  // Exemplo, só limpa usuário antigo
// Não chamar session_destroy() aqui, apenas no logout real
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistema</title>

    <!-- CSS e Bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="shortcut icon" href="/sa_mod_bd/img/favicon-16x16.ico" type="image/x-icon">
    <link rel="stylesheet" href="/sa_mod_bd/Login/index.css">
</head>

<body>
<main class="container">
    <div class="topoPag">
        <img class="imagemLogo" src="/sa_mod_bd/img/techinho.png" alt="Logo Techinho">
    </div>

    <div class="Formulario">
        <form method="POST" action="/sa_mod_bd/Login/login.php">
            <div class="informacoes">
                <input name="email" id="email" type="email" placeholder="Digite seu email corporativo" class="form-control">
                <div class="password-container">
                    <input name="senha" id="senha" type="password" placeholder="Digite sua senha" class="form-control">
                    <span class="password-toggle" id="passwordToggle">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>
            <div class="interacoes">
                <button id="login" class="btn btn-primary" type="submit">Logar</button>
                <a href="/sa_mod_bd/Login/esqueci_senha.php">Esqueci minha senha</a>
            </div>
            <div class="rodape">
                <footer class="text-center mt-5"> <small>© 2025 Conserta Tech - Suporte: (47) 98472-8108</small>
                </footer>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../Login/inicio.js"></script>

    <script>
        // Mostrar/ocultar senha
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('senha');
            const passwordToggle = document.getElementById('passwordToggle');
            const eyeIcon = passwordToggle.querySelector('i');
            
            passwordToggle.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            });
        });
    </script>

    <?php if ($mensagem): ?>
    <script>
        const notyf = new Notyf({
            duration: 4000,
            position: { x: 'center', y: 'top' },
            types: [
                {
                    type: 'error',
                    background: '#dc3545',
                    icon: { className: 'bi bi-x-circle-fill', tagName: 'i', text: '' }
                }
            ]
        });

        <?php if ($mensagem === "desativado"): ?>
            notyf.error('Sua conta foi desativada, contate o administrador.');
        <?php elseif ($mensagem === "senha_incorreta"): ?>
            notyf.error('Senha incorreta, tente novamente.');
        <?php elseif ($mensagem === "usuario_inexistente"): ?>
            notyf.error('Usuário não encontrado.');
        <?php endif; ?>
    </script>
    <?php endif; ?>

</main>
</body>
</html>
