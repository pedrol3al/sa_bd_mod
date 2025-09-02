<?php
    session_start();
    require_once '../Conexao/conexao.php';

    //verifica se o cliente tem permissao de adm ou secretaria
    if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2){
        echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
        exit();
    }

    $cliente=[]; //inicializa a variavel para evitar erros

    //se o formulario for enviado, busca o cliente pelo id ou nome
    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])){
        $busca=trim($_POST['busca']);

        //verifica se a busca é um numero ou nome
        if(is_numeric($busca)){
            $sql="SELECT * FROM cliente WHERE id_cliente = :busca ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
        } else {
            $sql="SELECT * FROM cliente WHERE nome LIKE :busca_nome ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"$busca%", PDO::PARAM_STR); //MUDAR AQUI PARA A ENTREGA (ja mudei)
        }
    } else {
        $sql="SELECT * FROM cliente ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
    }
    $stmt->execute();
    $clientes=$stmt->fetchAll(PDO::FETCH_ASSOC);
    
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
    <title>Buscar cliente</title>
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="cliente.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="cliente_pesquisar.css" />
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
        <h2 align="center">Clientes</h2>

        <!-- Campo de busca -->
        <form action="buscar_cliente.php" method="POST" class="mb-4">
            <label for="busca_cliente" class="form-label fw-bold">Digite o ID ou Nome do cliente:</label>
            <div class="input-group input-group-lg shadow-sm">
                <input type="text" id="busca_cliente" name="busca_cliente" class="form-control border-start-0" placeholder="Ex: 12 ou João" required>
                <button class="btn btn-primary px-4" type="submit">Buscar</button>
            </div>
        </form>

        <!-- Resultado -->
        <?php if(!empty($clientes)): ?>
            <div class="container">
                <table id="tabela_pesquisa" border="1" class="table table-light table-hover">
                    <tr>
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
                            <td>
                                <img src="../img/<?= htmlspecialchars($cliente['foto_cliente']) ?>" 
                                     alt="Foto do cliente" width="50" height="50">
                            </td>
                            <td>
                                <a class="btn btn-warning" href="alterar_cliente.php?id=<?=htmlspecialchars($cliente['id_cliente'])?>">Alterar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else: ?>
            <p align="center">Nenhum cliente encontrado.</p> 
        <?php endif; ?>
    </div>
</main>

<!-- Máscaras + Flatpickr -->
<script>
$(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
    $('#cnpj').mask('00.000.000/0000-00');
    $('#telefone, #telefone_jur').mask('(00) 00000-0000');
    $('#cep, #cep_jur').mask('00000-000');
    flatpickr("#dataNascimento", {dateFormat: "d/m/Y"});
    flatpickr("#dataFundacao", {dateFormat: "d/m/Y"});
});
</script>

<script src="../Menu_lateral/carregar-menu.js" defer></script>
<script src="cliente.js"></script>
</body>
</html>