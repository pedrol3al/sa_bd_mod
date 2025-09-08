<?php
session_start();
require_once("../Conexao/conexao.php");

// Função para sanitizar dados
function safe_html($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Buscar todos os usuários ativos
$sql = "SELECT * FROM usuario WHERE inativo = 0 ORDER BY nome";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll();

// Verificar se há um ID de usuário para editar
$usuarioAtual = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];
    $sql = "SELECT * FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    $usuarioAtual = $stmt->fetch();
}

// Processar inativação de usuário
if (isset($_GET['inativar']) && is_numeric($_GET['inativar'])) {
    $id_inativar = $_GET['inativar'];
    $sql = "UPDATE usuario SET inativo = 1 WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_inativar, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: processa_alteracao_cliente.php?inactivated=1&id=" . $id_inativar);
        exit();
    } else {
        header("Location: processa_alteracao_cliente.php?error=1");
        exit();
    }
}

// Processar ativação de usuário
if (isset($_GET['ativar']) && is_numeric($_GET['ativar'])) {
    $id_ativar = $_GET['ativar'];
    $sql = "UPDATE usuario SET inativo = 0 WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_ativar, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: processa_alteracao_cliente.php?activated=1&id=" . $id_ativar);
        exit();
    } else {
        header("Location: processa_alteracao_cliente.php?error=1");
        exit();
    }
}

// Processar atualização de dados do usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    $perfil = $_POST['perfil'];
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'] ?? null;
    $data_nasc = $_POST['data_nasc'] ?? null;
    $cep = $_POST['cep'] ?? null;
    $logradouro = $_POST['logradouro'] ?? null;
    $numero = $_POST['numero'] ?? null;
    $cidade = $_POST['cidade'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $bairro = $_POST['bairro'] ?? null;
    $telefone = $_POST['telefone'] ?? null;

    $sql = "UPDATE usuario SET 
            id_perfil = :perfil, 
            nome = :nome, 
            username = :username, 
            email = :email, 
            cpf = :cpf, 
            data_nasc = :data_nasc, 
            cep = :cep, 
            logradouro = :logradouro, 
            numero = :numero, 
            cidade = :cidade, 
            uf = :estado, 
            bairro = :bairro, 
            telefone = :telefone 
            WHERE id_usuario = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':perfil', $perfil, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $stmt->bindParam(':data_nasc', $data_nasc, PDO::PARAM_STR);
    $stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
    $stmt->bindParam(':logradouro', $logradouro, PDO::PARAM_STR);
    $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
    $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: processa_alteracao_cliente.php?updated=1&id=" . $id_usuario);
        exit();
    } else {
        header("Location: processa_alteracao_cliente.php?error=1");
        exit();
    }
}

?>
