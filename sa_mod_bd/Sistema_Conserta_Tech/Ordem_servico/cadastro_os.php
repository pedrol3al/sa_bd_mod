<?php
session_start();
require_once '../Conexao/conexao.php';

//verifica se o usuario tem permissao 
//supondo que o perfil 1 seja o administrador

if ($_SESSION['perfil'] != 1) {
    echo "Acesso Negado!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'];
    $id_usuario = $_POST['id_usuario'];
    $num_serie = $_POST['num_serie'];
    $data_abertura = $_POST['data_abertura'];
    $data_termino = $_POST['data_termino'];
    $modelo = $_POST['modelo'];
    $num_aparelho = $_POST['num_aparelho'];
    $defeito_rlt = $_POST['defeito_rlt'];
    $condicao = $_POST['condicao'];
    $fabricante = $_POST['fabricante'];
    $observacoes = $_POST['observacoes'];

    $sql = "INSERT INTO os(id_cliente, id_usuario, num_serie, data_abertura, data_termino, modelo, num_aparelho, defeito_rlt, condicao, observacoes, fabricante) 
                VALUES (:id_cliente, :id_usuario, :num_serie, :data_abertura, :data_termino, :modelo, :num_aparelho, :defeito_rlt, :condicao, :observacoes, :fabricante)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':num_serie', $num_serie);
    $stmt->bindParam(':data_abertura', $data_abertura);
    $stmt->bindParam(':data_termino', $data_termino);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':num_aparelho', $num_aparelho);
    $stmt->bindParam(':defeito_rlt', $defeito_rlt);
    $stmt->bindParam(':condicao', $condicao);
    $stmt->bindParam(':fabricante', $fabricante);
    $stmt->bindParam(':observacoes', $observacoes);

    if ($stmt->execute()) {
        echo "<script>alert('Ordem de serviço cadastrada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar ordem de serviço');</script>";
    }
}