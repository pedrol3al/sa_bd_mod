<?php
    // Inicia ou resume uma sessão existente para acessar variáveis de sessão
    session_start();
    // Inclui o arquivo de conexão com o banco de dados
    require '../Conexao/conexao.php';

    // Verifica se o usuário tem permissão de administrador (perfil 1)
    // Se não for administrador, exibe alerta e redireciona
    if($_SESSION['perfil'] != 1){
        echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
        exit(); // Termina a execução do script
    }

    // Inicializa variável para armazenar a lista de clientes (como array vazio)
    $clientes = [];

    // Busca todos os clientes cadastrados em ordem alfabética
    $sql = "SELECT * FROM cliente ORDER BY nome ASC"; // Query SQL para selecionar todos os clientes ordenados por nome
    $stmt = $pdo->prepare($sql); // Prepara a query para execução
    $stmt->execute(); // Executa a query no banco de dados
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Armazena todos os resultados como array associativo

    // Verifica se um ID foi passado via GET e se é numérico (para exclusão)
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id_cliente = $_GET['id']; // Armazena o ID do cliente a ser excluído

        // Prepara a query SQL para excluir o cliente do banco de dados
        $sql = "DELETE FROM cliente WHERE id_cliente = :id"; // Query com parâmetro nomeado
        $stmt = $pdo->prepare($sql); // Prepara a query para execução
        $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT); // Associa o parâmetro :id ao valor, especificando que é inteiro

        // Tenta executar a exclusão e verifica se foi bem-sucedida
        if($stmt->execute()){
            // Se a exclusão foi bem-sucedida, exibe alerta de sucesso e recarrega a página
            echo "<script>alert('Cliente excluído com sucesso!');window.location.href='excluir_cliente.php';</script>";
        } else {
            // Se houve erro na exclusão, exibe alerta de erro
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