<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 5) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php'</script>";
    exit();
}

// Processar exclusão se solicitado
if (isset($_GET['excluir_produto']) && isset($_GET['id'])) {
    try {
        $id_produto = $_GET['id'];

        // Verificar se o produto está vinculado a alguma OS antes de excluir
        $sql_check = "SELECT COUNT(*) as total FROM os_produto WHERE id_produto = :id_produto";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':id_produto', $id_produto);
        $stmt_check->execute();
        $result = $stmt_check->fetch();

        if ($result['total'] > 0) {
            $_SESSION['mensagem'] = 'Não é possível excluir este produto pois está vinculado a ordens de serviço!';
            $_SESSION['tipo_mensagem'] = 'error';
            header('Location: buscar_produto.php');
            exit;
        }

        // Excluir produto
        $sql = "DELETE FROM produto WHERE id_produto = :id_produto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_produto', $id_produto);
        $stmt->execute();

        $_SESSION['mensagem'] = 'Produto excluído com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';

        header('Location: buscar_produto.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao excluir produto: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_produto.php');
        exit;
    }
}

$produtos = []; // inicializa a variável para evitar erros

// Se o formulário for enviado, busca o produto pelo id ou nome
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);

    // Verifica se a busca é um número ou nome
    if (is_numeric($busca)) {
        $sql = "SELECT p.*, f.razao_social as fornecedor_nome 
                FROM produto p 
                INNER JOIN fornecedor f ON p.id_fornecedor = f.id_fornecedor 
                WHERE p.id_produto = :busca 
                ORDER BY p.nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT p.*, f.razao_social as fornecedor_nome 
                FROM produto p 
                INNER JOIN fornecedor f ON p.id_fornecedor = f.id_fornecedor 
                WHERE p.nome LIKE :busca_nome 
                ORDER BY p.nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
    }
} else {
    $sql = "SELECT p.*, f.razao_social as fornecedor_nome 
            FROM produto p 
            INNER JOIN fornecedor f ON p.id_fornecedor = f.id_fornecedor 
            ORDER BY p.nome ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Produtos</title>

    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="buscar.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">


</head>

<body>
    <?php include("../Menu_lateral/menu.php"); ?>

    <div class="container">
        <h1>BUSCAR PRODUTOS (ESTOQUE)</h1>

        <!-- Seção de busca -->
        <div class="search-section">
            <form method="POST" action="">
                <div class="search-container">
                    <input type="text" name="busca" class="form-control search-input"
                        placeholder="Buscar por ID ou Nome do Produto..."
                        value="<?= isset($_POST['busca']) ? htmlspecialchars($_POST['busca']) : '' ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                    <?php if (isset($_POST['busca']) && !empty($_POST['busca'])): ?>
                        <a href="buscar_produto.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Limpar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Tabela de resultados -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-box-seam"></i> Produtos Encontrados
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Fornecedor</th>
                                <th>Tipo</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Data Registro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($produtos) > 0): ?>
                                <?php foreach ($produtos as $produto): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($produto['id_produto']) ?></td>
                                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                                        <td><?= htmlspecialchars($produto['fornecedor_nome']) ?></td>
                                        <td><?= htmlspecialchars($produto['tipo']) ?></td>
                                        <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                        <td><?= date('d/m/Y', strtotime($produto['data_registro'])) ?></td>
                                        <td class="actions">
                                            <a href="alterar_produto.php?id=<?= $produto['id_produto'] ?>"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil"></i> Alterar/Excluir
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="no-results">
                                        <i class="bi bi-search" style="font-size: 3rem;"></i>
                                        <h4>Nenhum produto encontrado</h4>
                                        <p><?= (isset($_POST['busca']) && !empty($_POST['busca'])) ? 'Tente ajustar os termos da busca.' : 'Não há produtos cadastrados.' ?>
                                        </p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <p align="center">
            <a class="btn btn-secondary" role="button" href="buscar_produto.php">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
            <a class="btn btn-success" role="button" href="cadastro_produto.php">
                <i class="bi bi-plus-circle"></i> Novo Produto
            </a>
        </p>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top'
                },
                duration: 3000,
                ripple: true,
                dismissible: false
            });

            // Mostrar mensagens de sessão
            <?php if (isset($_SESSION['mensagem'])): ?>
                notyf.<?= $_SESzSION['tipo_mensagem'] === 'error' ? 'error' : 'success' ?>('<?= $_SESSION['mensagem'] ?>');
                <?php
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>
        });
    </script>
</body>

</html>