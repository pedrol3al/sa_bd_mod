<?php
session_start();
require_once('../Conexao/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        //LOGIN BEM SUCEDIDO DEFINE VARIAVEIS DE SESSÃO
        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['id_perfil'];
        $_SESSION['id_usuario'] = $usuario['id_usuario'];

        //VERIFICA SE A SENHA É TEMPORARIA 
        if ($usuario['senha_temporaria']) {
            //REDIRECIONA PARA A TROCA DE SENHA
            header("Location: ../Trocar_senha/alterar_senha.php");
            exit();
        } else {
            //REDIRECIONA PARA A PAGINA PRINCIPAL
            header("Location: ../Principal/main.php");
            exit();
        }
    } // LOGIN INVÁLIDO
    echo "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <link rel='stylesheet' href='../Assets/sweetalert2.min.css'>
        <script src='../Assets/sweetalert2.all.min.js'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'E-mail ou senha incorretos!'
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>
    </body>
    </html>
    ";
}    
?>