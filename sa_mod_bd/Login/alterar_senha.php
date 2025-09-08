<?php
    session_start();
    require_once '../Conexao/conexao.php';

    //garante que o usuario esteja logado
    if(!isset($_SESSION['id_usuario'])){
        echo "<script>alert('Acesso Negado!');window.location.href='../index.php';</script>";
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
                echo "<script>alert('Senha alterada com sucesso! Faça login novamente.');window.location.href='../index.php';</script>";
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

    <link rel="stylesheet" href="alterar.css">
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