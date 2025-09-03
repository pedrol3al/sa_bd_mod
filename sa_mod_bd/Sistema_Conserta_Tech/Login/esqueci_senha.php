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
            echo "<script>alert('Uma senha temporaria foi gerada e enviada (simulação). Verifique o arquivo emails_simulados.txt'); window.location.href='index.php';</script>";
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

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --dark-color: #2e59d9;
            --light-color: #f8f9fc;
            --danger-color: #e74a3b;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            padding: 20px;
        }
        
        .login-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }
        
        .login-header {
            background: var(--primary-color);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 24px;
        }
        
        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #4a4a4a;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
            outline: none;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: var(--dark-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-top: 20px;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            color: var(--dark-color);
            text-decoration: none;
        }
        
        .login-footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fc;
            border-top: 1px solid #e3e6f0;
            font-size: 14px;
            color: #858796;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo img {
            height: 60px;
        }
        
        @media (max-width: 576px) {
            .login-container {
                border-radius: 10px;
            }
            
            .login-header {
                padding: 20px;
            }
            
            .login-body {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Recuperar Senha</h2>
            <p>Informe seu e-mail para receber uma senha temporária</p>
        </div>
        
        <div class="login-body">
            <div class="logo">
                <img src="../img/logo.png" alt="Conserta Tech Logo">
            </div>
            
            <form action="esqueci_senha.php" method="POST">
                <div class="form-group">
                    <label for="email">E-mail cadastrado</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="seu.email@exemplo.com" required>
                </div>
                
                <button type="submit" class="btn-primary">Enviar Senha Temporária</button>
                
                <a href="index.php" class="back-link">
                    <i class="bi bi-arrow-left"></i> Voltar para o login
                </a>
            </form>
        </div>
        
        <div class="login-footer">
            &copy; 2023 Sistema Conserta Tech - Todos os direitos reservados
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