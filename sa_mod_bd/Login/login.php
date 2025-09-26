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

    if ($usuario) {
        if ($usuario['inativo'] == 1) {
            $_SESSION['msg'] = "error"; // Usuário inativo
            header("Location: ../../index.php");
            exit();
        }

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = $usuario['nome'];
            $_SESSION['perfil'] = $usuario['id_perfil'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];

            if ($usuario['senha_temporaria']) {
                header("Location: alterar_senha.php");
            } else {
                header("Location: ../Principal/main.php");
            }
            exit();
        } else {
            $_SESSION['msg'] = "senha_incorreta"; // Senha incorreta
            header("Location: ../../index.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = "usuario_inexistente"; // Usuário não encontrado
        header("Location: ../../index.php");
        exit();
    }
}
