<?php
// Inicia a sessão para acessar variáveis de sessão
session_start();
// Inclui o arquivo de conexão com o banco
require_once '../Conexao/conexao.php';

// Verifica se o usuário tem perfil de admin (1) ou estoque (5)
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 5) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php'</script>";
    exit();
}

// Inicializa variáveis
$fornecedores = [];
$error_message = '';

// Busca fornecedores ativos do banco
try {
    $sql_fornecedores = "SELECT id_fornecedor, razao_social FROM fornecedor WHERE inativo = 0 ORDER BY razao_social";
    $stmt_fornecedores = $pdo->prepare($sql_fornecedores);
    $stmt_fornecedores->execute();
    $fornecedores = $stmt_fornecedores->fetchAll();
} catch (PDOException $e) {
    $error_message = "Erro ao carregar fornecedores: " . $e->getMessage();
}

// Processa o formulário quando enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtém dados do formulário
        $id_usuario = $_SESSION['id_usuario'];
        $id_fornecedor = $_POST['id_fornecedor'];
        $tipo = $_POST['tipo'];
        $nome = $_POST['nome'];
        $aparelho_utilizado = $_POST['aparelho_utilizado'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $data_registro = $_POST['data_registro'];
        $descricao = $_POST['descricao'];

        // Valida campos obrigatórios
        if (empty($id_fornecedor) || empty($tipo) || empty($nome) || $quantidade === '' || $preco === '') {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos!");
        }

        // Prepara query para inserir novo produto
        $sql = "INSERT INTO produto (
            id_usuario, id_fornecedor, tipo, nome, aparelho_utilizado, 
            quantidade, preco, data_registro, descricao
        ) VALUES (
            :id_usuario, :id_fornecedor, :tipo, :nome, :aparelho_utilizado, 
            :quantidade, :preco, :data_registro, :descricao
        )";

        $stmt = $pdo->prepare($sql);
        // Associa parâmetros para prevenir SQL injection
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_fornecedor', $id_fornecedor);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':aparelho_utilizado', $aparelho_utilizado);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':data_registro', $data_registro);
        $stmt->bindParam(':descricao', $descricao);

        if ($stmt->execute()) {
            // Redireciona com flag de sucesso
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit();
        } else {
            throw new Exception("Erro ao executar a query de inserção.");
        }

    } catch (Exception $e) {
        $error_message = 'Erro ao cadastrar produto: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos (Estoque)</title>

    <!-- Links para CSS e frameworks -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="cadastro.css">
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">
</head>

<body>
<div class="container">
    <h1>CADASTRO DE PRODUTOS (ESTOQUE)</h1>

    <?php include("../Menu_lateral/menu.php"); ?>

    <!-- Exibe mensagem de erro se existir -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-section">
            <h2>Dados do Produto</h2>

            <div class="form-row">
                <!-- Seleção de fornecedor -->
                <div class="form-group">
                    <label for="id_fornecedor" class="form-label">Fornecedor:</label>
                    <select id="id_fornecedor" name="id_fornecedor" class="form-control" required>
                        <option value="">Selecione um fornecedor</option>
                        <?php foreach ($fornecedores as $fornecedor): ?>
                            <option value="<?= $fornecedor['id_fornecedor'] ?>">
                                <?= htmlspecialchars($fornecedor['razao_social']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Seleção de tipo de produto -->
                <div class="form-group">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <select id="tipo" name="tipo" class="form-control" required>
                        <option value="">Selecione o tipo</option>
                        <option value="Peça">Peça</option>
                        <option value="Componente">Componente</option>
                        <option value="Acessório">Acessório</option>
                        <option value="Material">Material</option>
                        <option value="Equipamento">Equipamento</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <!-- Nome do produto -->
                <div class="form-group">
                    <label for="nome" class="form-label">Nome do Produto:</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>

                <!-- Aparelho utilizado -->
                <div class="form-group">
                    <label for="aparelho_utilizado" class="form-label">Aparelho Utilizado:</label>
                    <input type="text" id="aparelho_utilizado" name="aparelho_utilizado" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <!-- Quantidade em estoque -->
                <div class="form-group">
                    <label for="quantidade" class="form-label">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" class="form-control" min="0" value="0" required>
                </div>

                <!-- Preço unitário -->
                <div class="form-group">
                    <label for="preco" class="form-label">Preço Unitário (R$):</label>
                    <input type="number" id="preco" name="preco" class="form-control" step="0.01" min="0" required>
                </div>
            </div>

            <div class="form-row">
                <!-- Data de registro -->
                <div class="form-group">
                    <label for="data_registro" class="form-label">Data de Registro:</label>
                    <input type="date" id="data_registro" name="data_registro" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <div class="form-row">
                <!-- Descrição do produto -->
                <div class="form-group">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>

        <!-- Botões de ação -->
        <div class="actions">
            <button type="button" class="btn btn-danger" onclick="window.history.back()">
                <i class="bi bi-x-circle"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Cadastrar Produto
            </button>
        </div>
    </form>
</div>

<!-- Scripts JavaScript -->
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<!-- Exibe notificação de sucesso se o cadastro foi bem-sucedido -->
<?php if (isset($_GET['success'])): ?>
<script>
    const notyf = new Notyf({ position: { x: 'right', y: 'top' }, duration: 4000 });
    notyf.success('Produto cadastrado com sucesso!');
</script>
<?php endif; ?>

<!-- Formata o preço para 2 casas decimais quando o campo perde o foco -->
<script>
    const precoInput = document.getElementById('preco');
    precoInput.addEventListener('blur', function () {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
</script>
</body>
</html>