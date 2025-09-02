<?php
session_start();
require_once '../Conexao/conexao.php';

// Verifica permissão de administrador ou secretaria
if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

$usuarios = []; // Inicializa a variável

// Se o formulário for enviado, busca pelo ID ou nome
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca_usuario'])){
    $busca = trim($_POST['busca_usuario']);

    if(is_numeric($busca)){
        $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
    }
} else {
    $sql = "SELECT * FROM usuario ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuário</title>
    <link rel="stylesheet" href="usuario.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body class="corpo">

<?php include("../Menu_lateral/menu.php"); ?>

<main>
<div class="conteudo">
<h2 align="center">Usuários</h2>

<form action="buscar_usuario.php" method="POST" class="mb-4">
    <label for="busca_usuario" class="form-label fw-bold">Digite o ID ou Nome do Usuário:</label>
    <div class="input-group input-group-lg shadow-sm">
        <input type="text" id="busca_usuario" name="busca_usuario" class="form-control border-start-0" placeholder="Ex: 12 ou João" required>
        <button class="btn btn-primary px-4" type="submit">Buscar</button>
    </div>
</form>

<?php if(!empty($usuarios)): ?>
<div class="container">
<table id="tabela_pesquisa" border="1" class="table table-light table-hover">
    <tr>
        <th>ID</th>
        <th>Perfil</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Username</th>
        <th>Email</th>
        <th>Data de Cadastro</th>
        <th>Data de Nascimento</th>
        <th>Sexo</th>
        <th>Ações</th>
    </tr>
    <?php foreach($usuarios as $usuario): ?>
    <tr>
        <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
        <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
        <td><?=htmlspecialchars($usuario['nome'])?></td>
        <td><?=htmlspecialchars($usuario['cpf'])?></td>
        <td><?=htmlspecialchars($usuario['username'])?></td>
        <td><?=htmlspecialchars($usuario['email'])?></td>
        <td><?=htmlspecialchars($usuario['data_cad'])?></td>
        <td><?=htmlspecialchars($usuario['data_nasc'])?></td>
        <td><?=htmlspecialchars($usuario['sexo'])?></td>
        <td>
            <a class="btn btn-warning" href="alterar_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>">Alterar</a>
            <br><br>
            <a class="btn btn-danger" href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>" onclick="return confirm('Tem certeza da exclusão?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p align="center">Nenhum usuário encontrado.</p> 
<?php endif; ?>
</div>
</main>

<script src="../Menu_lateral/carregar-menu.js" defer></script>
<script src="usuario.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>
