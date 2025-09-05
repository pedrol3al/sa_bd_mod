<?php
    session_start();
    require '../Conexao/conexao.php';

    //verifica se o usuario tem permissao de adm
    if($_SESSION['perfil'] !=1){
        echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
        exit();
    }

    //inicializa vriavel para amarzenar usuarios
    $clientes=[];

    //busca todos os usuarios cadastrados em ordem alfabetica
    $sql="SELECT * FROM cliente ORDER BY nome ASC";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $clientes=$stmt->fetchAll(PDO::FETCH_ASSOC);

    //se um id for passado via get exclui o usuario
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id_cliente=$_GET['id'];

        //exclui o usuario do banco de dados
        $sql="DELETE FROM cliente WHERE id_cliente =:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id_cliente,PDO::PARAM_INT);

        if($stmt->execute()){
            echo "<script>alert('Cliente excluído com sucesso!');window.location.href='excluir_cliente.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir o cliente!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir usuário</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="cliente.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- Link notfy -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Link das máscaras dos campos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
</body>
</html>