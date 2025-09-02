<?php
session_start();
require '../Conexao/conexao.php';


if($_SESSION['perfil'] !=1){
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit();
}

// Se um POST for enviado, atualiza o cliente
if(isset($_POST['id_cliente'], $_POST['nome'], $_POST['email'])){
    $id_cliente = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql="UPDATE cliente SET nome=:nome, email=:email WHERE id_cliente=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Cliente alterado com sucesso!');window.location.href='alterar_cliente.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao alterar o cliente!');</script>";
    }
}

// Se um GET com id for passado, busca os dados do cliente
$clienteAtual = null;
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_cliente = $_GET['id'];
    $sql="SELECT * FROM cliente WHERE id_cliente=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    $clienteAtual = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Busca todos os clientes para exibir na tabela
$sql="SELECT * FROM cliente ORDER BY nome ASC";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$clientes=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar cliente</title>
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="cliente.css" />
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
<body class="corpo">

<?php
  include("../Menu_lateral/menu.php"); 
?>


    <main>
    <div class="conteudo">
    <h2 align="center">Alterar Cliente</h2>
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
                    <a class="btn btn-warning" role="button" href="alterar_cliente.php?id=<?=htmlspecialchars($cliente['id_cliente'])?>" onclick="return confirm('Tem certeza de que deseja alterar este cliente?')">Alterar</a>                
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum cliente encontrado!</p>
    <?php endif; ?>

    <?php if($clienteAtual): ?>
<form action="alterar_cliente.php" method="POST">
    <input type="hidden" name="id_cliente" value="<?=htmlspecialchars($clienteAtual['id_cliente'])?>">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($clienteAtual['nome'])?>" required>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?=htmlspecialchars($clienteAtual['email'])?>" required>

    <label for="observacao">Observação:</label>
    <input type="text" id="observacao" name="observacao" value="<?=htmlspecialchars($clienteAtual['observacao'])?>">

    
</form>
<?php endif; ?>



    </div>
    </div>
    </main>
    </div>
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="cliente.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>