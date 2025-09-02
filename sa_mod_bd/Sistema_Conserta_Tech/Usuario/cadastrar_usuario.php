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
        (id_perfil, nome, cpf, username, email, senha, data_cad, data_nasc, foto_usuario, sexo, senha_temporaria)
        VALUES (:id_perfil, :nome, :cpf, :username, :email, :senha, :data_cad, :data_nasc, :foto_usuario, :sexo, :senha_temporaria)";
        
        $stmt = $pdo->prepare($sqlUsuario);
        $stmt->execute([
            ':id_perfil' => $_POST['cargo_usuario'],      
            ':nome' => $_POST['nome_usuario'],            
            ':cpf' => $_POST['cpf_usuario'],
            ':username' => $_POST['username'],            
            ':email' => $_POST['email_usuario'],
            ':senha' => password_hash($_POST['senha_usuario'], PASSWORD_DEFAULT),
            ':data_cad' => $_POST['dataCadastro'],
            ':data_nasc' => $_POST['dataNascimento'],
            ':foto_usuario' => $foto_usuario,
            ':sexo' => $_POST['sexo_usuario'],
            ':senha_temporaria' => 0
        ]);
        
        

        // Pega o id do usuário gerado automaticamente pelo banco
        $id_usuario = $pdo->lastInsertId();

        // ---------- INSERT endereço ----------
        $sql = "INSERT INTO endereco_usuario 
            (id_usuario, cep, logradouro, tipo_rua, complemento, numero, cidade, uf, bairro)
            VALUES (:id_usuario, :cep, :logradouro, :tipo_rua, :complemento, :numero, :cidade, :uf, :bairro)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':cep' => $_POST['cep_usuario'],
            ':logradouro' => $_POST['logradouro_usuario'],
            ':tipo_rua' => $_POST['tipo_casa'],
            ':complemento' => $_POST['complemento_usuario'],
            ':numero' => $_POST['numero_usuario'],
            ':cidade' => $_POST['cidade_usuario'],
            ':uf' => $_POST['uf_usuario'],
            ':bairro' => $_POST['bairro_usuario'] 
        ]);

        // ---------- INSERT telefone ----------
        $sql = "INSERT INTO telefone_usuario (id_usuario, telefone) 
                        VALUES (:id_usuario, :telefone)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $id_usuario,   
            ':telefone' => $_POST['telefone_usuario'] 
        ]);
     

        $pdo->commit(); // confirma tudo
        echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
    }
} catch (Exception $e) {
    $pdo->rollBack(); // desfaz tudo se deu erro
    echo "Erro no cadastro: " . $e->getMessage();
}
?>