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
    <title>Recuperar senha</title>
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="estilo_alterar.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- Link notfy -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Link das máscaras dos campos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
    <main>
    <div class="container">
        <a href="index.php" id="voltar" class="bi bi-arrow-left"></a>
        <h2 align="center" id="tit_senha">Recuperar senha</h2>
        <form action="esqueci_senha.php" method="POST">
            <label for="email">Digite o seu E-mail cadastrado</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Enviar a senha temporária</button>
        </form>
    </div>
    </main>
</body>
</html>