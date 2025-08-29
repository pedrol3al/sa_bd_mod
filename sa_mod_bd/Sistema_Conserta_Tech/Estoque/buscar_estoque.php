<?php
session_start();
require_once("../Conexao/conexao.php");

if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

$estoques = []; // inicializa a variável para evitar erros

// se o formulário for enviado, busca o estoque pelo id ou nome
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    // verifica se a busca é um número ou nome
    if(is_numeric($busca)){
        $sql = "SELECT e.*, f.razao_social 
                FROM estoque e
                INNER JOIN fornecedor f ON e.id_fornecedor = f.id_fornecedor
                WHERE e.id_estoque = :busca
                ORDER BY e.nome_peca ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT e.*, f.razao_social 
                FROM estoque e
                INNER JOIN fornecedor f ON e.id_fornecedor = f.id_fornecedor
                WHERE e.nome LIKE :busca_nome 
                ORDER BY e.nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
    }
} else {
    $sql = "SELECT e.*, f.razao_social 
            FROM estoque e
            INNER JOIN fornecedor f ON e.id_fornecedor = f.id_fornecedor";
    $stmt = $pdo->prepare($sql);
}
    $stmt->execute();
    $estoques=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar estoque</title>
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="css_estoque.css">
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
<body class="corpo">

    <div id="menu-container"></div>

    <main>
    <div class="conteudo">
    <h2 align="center">Estoque</h2>
    <form action="buscar_estoque.php" method="POST">
        <label for="busca">Digite o ID ou Nome(opcional): </label>
        <input type="text" id="busca" name="busca">
        <button class="btn btn-primary" type="submit">Pesquisar</button>
    </form>
    <?php if(!empty($estoques)): ?>
        <div class="container">
        <table id="tabela_pesquisa" border="1" class="table table-light table-hover">
            <tr class="table-secondary">
                <th>ID</th>
                <th>Nome</th>
                <th>Nome do fornecedor</th>
                <th>Data de cadastro</th>
                <th>Quantidade</th>
                <th>Valor unitário</th>
                <th>Descrição</th>
                <th>Foto da peça</th>
                <th>Ações</th>
            </tr>
            <?php foreach($estoques as $estoque): ?>
                <tr>
                    <td><?=htmlspecialchars($estoque['id_produto'])?></td>
                    <td><?=htmlspecialchars($estoque['nome_peca'])?></td>
                    <td><?=htmlspecialchars($estoque['razao_social'])?></td>
                    <td><?=htmlspecialchars($estoque['data_cadastro'])?></td>
                    <td><?=htmlspecialchars($estoque['quantidade'])?></td>
                    <td><?=htmlspecialchars($estoque['valor_unitario'])?></td>
                    <td><?=htmlspecialchars($estoque['descricao'])?></td>
                    <td><img src="../img/techinho.png<?= htmlspecialchars($estoque['imagem_peca']) ?>" 
                        alt="Foto do estoque" 
                        width="50" height="50">
                    </td>
                    <td>
                        <a class="btn btn-warning" href="alterar_estoque.php?id=<?=htmlspecialchars($estoque['id_produto'])?>">Alterar</a>
                        <a class="btn btn-danger" href="excluir_estoque.php?id=<?=htmlspecialchars($estoque['id_produto'])?>" onclick="return confirm('Tem certeza da exclusão?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php else: ?>
            <p align="center">Nenhum estoque encontrado.</p> 
        <?php endif; ?>
        </div>
        </br>
        <p align="center"><a class="btn btn-secondary" role="button" href="index.php">Voltar</a></p>
        </div>
    </main>
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="estoque.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>