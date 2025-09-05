<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../Conexao/conexao.php');

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
    die("Acesso Negado");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $pdo->beginTransaction();

        $sqlUsuario = "INSERT INTO usuario
        (id_perfil, nome, cpf, username, email, senha, data_cad, data_nasc, sexo, senha_temporaria, cep, logradouro, tipo, complemento, numero, cidade, uf, bairro, telefone)
        VALUES
        (:id_perfil, :nome, :cpf, :username, :email, :senha, :data_cad, :data_nasc, :sexo, :senha_temporaria, :cep, :logradouro, :tipo, :complemento, :numero, :cidade, :uf, :bairro, :telefone)";
        
        $stmt = $pdo->prepare($sqlUsuario);

        $sucesso = $stmt->execute([
            ':id_perfil'        => $_POST['cargo_usuario'],
            ':nome'             => $_POST['nome_usuario'],
            ':cpf'              => $_POST['cpf_usuario'],
            ':username'         => $_POST['username'],
            ':email'            => $_POST['email_usuario'],
            ':senha'            => password_hash($_POST['senha_usuario'], PASSWORD_DEFAULT),
            ':data_cad'         => $_POST['dataCadastro'],
            ':data_nasc'        => $_POST['dataNascimento'],
            ':sexo'             => $_POST['sexo_usuario'],
            ':senha_temporaria' => 0,
            ':cep'              => $_POST['cep_usuario'],
            ':logradouro'       => $_POST['logradouro_usuario'],
            ':tipo'             => $_POST['tipo_casa'], 
            ':complemento'      => $_POST['complemento_usuario'],
            ':numero'           => $_POST['numero_usuario'],
            ':cidade'           => $_POST['cidade_usuario'],
            ':uf'               => $_POST['uf_usuario'],
            ':bairro'           => $_POST['bairro_usuario'],
            ':telefone'         => $_POST['telefone_usuario']
        ]);

        if ($sucesso) {
            $pdo->commit();
            $_SESSION['msg'] = "success";
        } else {
            $pdo->rollback();
            $_SESSION['msg'] = "error";
        }

    } catch (PDOException $e) {
        $pdo->rollback();
        $_SESSION['msg'] = "error";
        // opcional: error_log($e->getMessage());
    }

    header("Location: usuario.php");
    exit();
}
?>
