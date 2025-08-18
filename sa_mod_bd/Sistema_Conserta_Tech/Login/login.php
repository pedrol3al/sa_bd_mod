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
            header("Location: alterar_senha.php");
            exit();
        } else {
            //REDIRECIONA PARA A PAGINA PRINCIPAL
            header("Location: ../Principal/main.html");
            exit();
        }
    } else {
        //LOGIN INVALIDO
        echo "<script>alert('E-Mail ou senha incorretos');window.location.href='login.html';</script>";
    }
}
?>