<?php
    session_start();
    require_once '../Conexao/conexao.php';

    //garante que o usuario esteja logado
    if(!isset($_SESSION['id_usuario'])){
        echo "<script>alert('Acesso Negado!');window.location.href='index.php';</script>";
        exit();
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $id_usuario=$_SESSION['id_usuario'];
        $nova_senha=$_POST['nova_senha'];
        $confirmar_senha=$_POST['confirmar_senha'];

        if($nova_senha !== $confirmar_senha){
            echo "<script>alert('As senhas não coincidem!');</script>";
        } elseif(strlen($nova_senha)<8){
            echo "<script>alert('A senha deve ter pelo menos 8 caracteres!');</script>";
        } elseif($nova_senha === "temp123"){
            echo "<script>alert('Escolha uma senha diferente da temporaria!');</script>";
        } else {
            $senha_hash=password_hash($nova_senha, PASSWORD_DEFAULT);

            //atualiza a senha e remove o status de temporaria
            $sql="UPDATE usuario SET senha=:senha, senha_temporaria=FALSE WHERE id_usuario=:id";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':senha',$senha_hash);
            $stmt->bindParam(':id',$id_usuario);

            if($stmt->execute()){
                session_destroy(); //finaliza a sessão
                echo "<script>alert('Senha alterada com sucesso! Faça login novamente.');window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Erro ao alterar a senha!');</script>";
            }
        }
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha - Sistema Conserta Tech</title>
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
            --text-color: #5a5c69;
        }
        
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            padding: 20px;
            color: var(--text-color);
        }

        /* Animação de fundo dinâmico */
        @keyframes moveBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(41, 128, 185, 0.3) 0%, transparent 25%),
                radial-gradient(circle at 80% 20%, rgba(52, 152, 219, 0.3) 0%, transparent 25%),
                radial-gradient(circle at 40% 40%, rgba(26, 188, 156, 0.2) 0%, transparent 25%);
            background-size: 200% 200%;
            animation: moveBackground 15s ease infinite;
            z-index: -1;
        }
        
        .password-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }
        
        .password-header {
            background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
        }
        
        .password-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 24px;
        }
        
        .password-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .back-link {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 20px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .password-body {
            padding: 30px;
        }
        
        .user-info {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .user-info p {
            margin: 0;
        }
        
        .user-info strong {
            color: var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
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
        
        .show-password {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .show-password input {
            margin-right: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
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
        
        .password-footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fc;
            border-top: 1px solid #e3e6f0;
            font-size: 14px;
            color: #858796;
        }
        
        @media (max-width: 576px) {
            .password-container {
                border-radius: 10px;
            }
            
            .password-header {
                padding: 20px;
            }
            
            .password-body {
                padding: 25px;
            }
            
            .back-link {
                position: relative;
                left: 0;
                top: 0;
                transform: none;
                display: inline-block;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="password-container">
        <div class="password-header">
            <a href="index.php" class="back-link">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2>Alterar Senha</h2>
            <p>Defina uma nova senha para sua conta</p>
        </div>
        
        <div class="password-body">
            <div class="user-info">
                <p>Olá, <strong><?php echo $_SESSION['usuario'];?></strong>. Digite sua nova senha abaixo:</p>
            </div>
            
            <form action="alterar_senha.php" method="POST">
                <div class="form-group">
                    <label for="nova_senha">Nova senha</label>
                    <input type="password" id="nova_senha" name="nova_senha" class="form-control" placeholder="Mínimo de 8 caracteres" required>
                </div>
                
                <div class="form-group">
                    <label for="confirmar_senha">Confirmar senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" placeholder="Digite a senha novamente" required>
                </div>
                
                <div class="show-password">
                    <input type="checkbox" id="mostrar-senha" onclick="mostrarSenha()">
                    <label for="mostrar-senha">Mostrar senhas</label>
                </div>
                
                <button type="submit" class="btn-primary">Salvar Nova Senha</button>
            </form>
        </div>
        
        <div class="password-footer">
            &copy; 2025 Sistema Conserta Tech - Todos os direitos reservados
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
        function mostrarSenha() {
            var senha1 = document.getElementById("nova_senha");
            var senha2 = document.getElementById("confirmar_senha");
            var tipo = senha1.type === "password" ? "text" : "password";
            senha1.type = tipo;
            senha2.type = tipo;
        }
        
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