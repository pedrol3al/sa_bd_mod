<?php
    session_start();
    require_once '../Conexao/conexao.php';
    require_once 'funcoes_email.php'; //arquivo com as funções que geram as senhas e simulam o envio

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $email=$_POST['email'];

        //verifica se o email existe no banco de dados
        $sql="SELECT * FROM usuario WHERE email=:email";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $usuario=$stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario){
            //gera uma senha temporaria e aleatoria
            $senha_temporaria=gerarSenhaTemporaria();
            $senha_hash=password_hash($senha_temporaria,PASSWORD_DEFAULT);

            //atualiza a senha do usuario no banco 
            $sql="UPDATE usuario SET senha=:senha,senha_temporaria=TRUE WHERE email=:email";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':senha',$senha_hash);
            $stmt->bindParam(':email',$email);
            $stmt->execute();

            //simula o envio do email (grava em txt)
            simularEnvioEmail($email,$senha_temporaria);
            echo "<script>alert('Uma senha temporaria foi gerada e enviada (simulação). Verifique o arquivo emails_simulados.txt'); window.location.href='../../index.php';</script>";
        } else {
            echo "<script>alert('E-mail não encontrado!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha - Sistema Conserta Tech</title>
    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <link rel="stylesheet" href="esqueci.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Recuperar Senha</h2>
            <p>Informe seu e-mail para receber uma senha temporária</p>
        </div>
        
        <div class="login-body">
            
            <form action="esqueci_senha.php" method="POST">
                <div class="form-group">
                    <label for="email">E-mail cadastrado</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="seu.email@exemplo.com" required>
                </div>
                
                <button type="submit" class="btn-primary">Enviar Senha Temporária</button>
                
                <a href="../../index.php" class="back-link">
                    <i class="bi bi-arrow-left"></i> Voltar para o login
                </a>
            </form>
        </div>
        
        <div class="login-footer">
            &copy; 2025 Sistema Conserta Tech - Todos os direitos reservados
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notyf = new Notyf();
            
            // Mostrar mensagens de alerta do PHP
            <?php if (isset($_SESSION['mensagem'])): ?>
                notyf.<?= $_SESSION['tipo_mensagem'] ?>('<?= $_SESSION['mensagem'] ?>');
                <?php
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>