<?php

//Reporta erros, caso houver
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../Conexao/conexao.php');

// Perfil vazio ou diferente de administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
    die("Acesso Negado");
}

try {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $pdo->beginTransaction(); // inicia transação


        // ---------- INSERT usuário ----------

        $sqlUsuario = "INSERT INTO usuario
        (id_perfil, nome, cpf, username, email, senha, data_cad, data_nasc, sexo, senha_temporaria, cep, logradouro, tipo, complemento, numero, cidade, uf, bairro, telefone)
        VALUES
        (:id_perfil, :nome, :cpf, :username, :email, :senha, :data_cad, :data_nasc, :sexo, :senha_temporaria, :cep, :logradouro, :tipo, :complemento, :numero, :cidade, :uf, :bairro, :telefone)";
        
        
        $stmt = $pdo->prepare($sqlUsuario);
        $stmt->execute([
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
            ':tipo'         => $_POST['tipo_casa'], 
            ':complemento'      => $_POST['complemento_usuario'],
            ':numero'           => $_POST['numero_usuario'],
            ':cidade'           => $_POST['cidade_usuario'],
            ':uf'               => $_POST['uf_usuario'],
            ':bairro'           => $_POST['bairro_usuario'],
            ':telefone'         => $_POST['telefone_usuario']
        ]);
        
        
        $pdo->commit(); // confirma tudo
        echo "<script>
        alert('Usuário cadastrado com sucesso!');
        window.location.href = 'usuario.php';
    </script>";
    
    }
} catch (Exception $e) {
    $pdo->rollBack(); // desfaz tudo se deu erro
    echo "Erro no cadastro: " . $e->getMessage();
    echo "<script>
        alert('Usuário cadastrado com sucesso!');
        window.location.href = 'usuario.php';
    </script>";
}
?>