<?php
session_start();
require_once('../Conexao/conexao.php');

//verifica se o fornecedor tem permissao 
//supondo que o perfil 1 seja o admin 

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=3) {
    echo "Acesso Negado";
}

if($_SERVER['REQUEST_METHOD']=="POST") {
    $id_fornecedor = $_POST['id_fornecedor'];
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];
    $data_fundacao = $_POST['data_fundacao'];
    $produto_fornecido = $_POST['produto_fornecido'];
    $data_cad = $_POST['data_cad'];
    $foto_fornecedor = $_POST['foto_fornecedor'];
    $contato = $_POST['contato'];

    $sql = "INSERT INTO fornecedor (id_fornecedor, email, nome, cnpj, data_fundacao, produto_fornecido, data_cad, foto_fornecedor) values (:id_fornecedor, :email, :nome, :cnpj, :data_fundacao, :produto_fornecido, :data_cad, :foto_fornecedor)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_fornecedor', $id_fornecedor);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cnpj', $cnpj);
    $stmt->bindParam(':data_fundacao', $data_fundacao);
    $stmt->bindParam(':produto_fornecido', $produto_fornecido);
    $stmt->bindParam(':data_cad', $data_cad);
    $stmt->bindParam(':foto_fornecedor', $foto_fornecedor);


    if($stmt->execute()) {
        echo "<script>alert('Fornecedor cadastrado com sucesso!');</script>";
    }else{
        echo "<script>alert('Erro ao cadastrar Fornecedor!');</script>";
    }
}
?>