<?php
session_start();
require '../Conexao/conexao.php';

if($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $observacao = $_POST['observacao'] ?? null;
    $data_nasc = $_POST['data_nasc'] ?? null;
    $sexo = $_POST['sexo'] ?? null;

    $sql = "UPDATE cliente 
            SET nome = :nome, email = :email, observacao = :observacao, data_nasc = :data_nasc, sexo = :sexo 
            WHERE id_cliente = :id_cliente";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':observacao', $observacao);
    $stmt->bindParam(':data_nasc', $data_nasc);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);

    if($stmt->execute()) {
        echo "<script>alert('Cliente atualizado com sucesso!');window.location.href='alterar_cliente.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar cliente!');window.location.href='alterar_cliente.php?id=$id_cliente';</script>";
    }
}
?>