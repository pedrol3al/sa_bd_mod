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
    <div id="menu-container"></div>
    <main>
    <div class="conteudo">
    <h2 align="center">Excluir cliente</h2>
    <?php if(!empty($clientes)): ?>
        <div class="container">
        <table border="1" align="center" class="table table-light table-hover">
            <tr class="table-secondary">
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Observação</th>
                <th>Data de nascimento</th>
                <th>Sexo</th>
                <th>Foto do cliente</th>
                <th>Ações</th>
            </tr>
            <?php foreach($clientes as $cliente): ?>
            <tr>
                <td><?=htmlspecialchars($cliente['id_cliente'])?></td>
                <td><?=htmlspecialchars($cliente['nome'])?></td>
                <td><?=htmlspecialchars($cliente['email'])?></td>
                <td><?=htmlspecialchars($cliente['observacao'])?></td>
                <td><?=htmlspecialchars($cliente['data_nasc'])?></td>
                <td><?=htmlspecialchars($cliente['sexo'])?></td>
                <td><img src="../img/techinho.png<?= htmlspecialchars($cliente['foto_cliente']) ?>" 
                    alt="Foto do cliente" 
                    width="50" height="50">
                </td>
                <td>
                    <a class="btn btn-danger" role="button" href="excluir_cliente.php?id=<?=htmlspecialchars($cliente['id_cliente'])?>" onclick="return confirm('Tem certeza de que deseja excluir este cliente?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum cliente encontrado!</p>
    <?php endif; ?>
    </br>
    <p align="center"><a class="btn btn-secondary" role="button" href="principal.php">Voltar</a></p>
    </div>
    </div>
    </main>
    
    </div>
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="cliente.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>