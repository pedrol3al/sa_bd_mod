<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    $_SESSION['mensagem'] = 'Acesso negado!';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../index.php');
    exit;
}

// Inicializar variáveis
$fornecedores = [];
$error_message = '';

// Buscar fornecedores do banco
try {
    $sql_fornecedores = "SELECT id_fornecedor, razao_social FROM fornecedor WHERE inativo = 0 ORDER BY razao_social";
    $stmt_fornecedores = $pdo->prepare($sql_fornecedores);
    $stmt_fornecedores->execute();
    $fornecedores = $stmt_fornecedores->fetchAll();
} catch (PDOException $e) {
    $error_message = "Erro ao carregar fornecedores: " . $e->getMessage();
}

// Processar o formulário apenas se for método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obter dados do formulário
        $id_usuario = $_SESSION['id_usuario'];
        $id_fornecedor = $_POST['id_fornecedor'];
        $tipo = $_POST['tipo'];
        $nome = $_POST['nome'];
        $aparelho_utilizado = $_POST['aparelho_utilizado'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $data_registro = $_POST['data_registro'];
        $descricao = $_POST['descricao'];

        // Validar dados
        if (empty($id_fornecedor) || empty($tipo) || empty($nome) || $quantidade === '' || $preco === '') {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos!");
        }

        // Inserir o produto
        $sql = "INSERT INTO produto (
            id_usuario, id_fornecedor, tipo, nome, aparelho_utilizado, 
            quantidade, preco, data_registro, descricao
        ) VALUES (
            :id_usuario, :id_fornecedor, :tipo, :nome, :aparelho_utilizado, 
            :quantidade, :preco, :data_registro, :descricao
        )";

        $stmt = $pdo->prepare($sql);
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
            $_SESSION['mensagem'] = 'Produto cadastrado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: buscar_produto.php');
            exit;
        } else {
            throw new Exception("Erro ao executar a query de inserção.");
        }

    } catch (Exception $e) {
        $error_message = 'Erro ao cadastrar produto: ' . $e->getMessage();
        // Não redirecionar, manter na mesma página para mostrar o erro
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos (Estoque)</title>

    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <style>
        .container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
            margin-left: 200px;
        }
        
        h1 {
            text-align: center;
            font-weight: bold;
            color: rgb(0, 0, 58);
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .form-group {
            flex: 1;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }
        
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }
        
        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CADASTRO DE PRODUTOS (ESTOQUE)</h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <!-- Exibir mensagens de erro -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $error_message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-section">
                <h2>Dados do Produto</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_fornecedor" class="form-label">Fornecedor:</label>
                        <select id="id_fornecedor" name="id_fornecedor" class="form-control" required>
                            <option value="">Selecione um fornecedor</option>
                            <?php foreach ($fornecedores as $fornecedor): ?>
                                <option value="<?= $fornecedor['id_fornecedor'] ?>" <?= (isset($_POST['id_fornecedor']) && $_POST['id_fornecedor'] == $fornecedor['id_fornecedor']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($fornecedor['razao_social']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo" class="form-label">Tipo:</label>
                        <select id="tipo" name="tipo" class="form-control" required>
                            <option value="">Selecione o tipo</option>
                            <option value="Peça" <?= (isset($_POST['tipo']) && $_POST['tipo'] == 'Peça') ? 'selected' : '' ?>>Peça</option>
                            <option value="Componente" <?= (isset($_POST['tipo']) && $_POST['tipo'] == 'Componente') ? 'selected' : '' ?>>Componente</option>
                            <option value="Acessório" <?= (isset($_POST['tipo']) && $_POST['tipo'] == 'Acessório') ? 'selected' : '' ?>>Acessório</option>
                            <option value="Material" <?= (isset($_POST['tipo']) && $_POST['tipo'] == 'Material') ? 'selected' : '' ?>>Material</option>
                            <option value="Equipamento" <?= (isset($_POST['tipo']) && $_POST['tipo'] == 'Equipamento') ? 'selected' : '' ?>>Equipamento</option>
                            <option value="Outro" <?= (isset($_POST['tipo']) && $_POST['tipo'] == 'Outro') ? 'selected' : '' ?>>Outro</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome do Produto:</label>
                        <input type="text" id="nome" name="nome" class="form-control" value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="aparelho_utilizado" class="form-label">Aparelho Utilizado:</label>
                        <input type="text" id="aparelho_utilizado" name="aparelho_utilizado" class="form-control" value="<?= isset($_POST['aparelho_utilizado']) ? htmlspecialchars($_POST['aparelho_utilizado']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="quantidade" class="form-label">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantidade" class="form-control" min="0" value="<?= isset($_POST['quantidade']) ? $_POST['quantidade'] : '0' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="preco" class="form-label">Preço Unitário (R$):</label>
                        <input type="number" id="preco" name="preco" class="form-control" step="0.01" min="0" value="<?= isset($_POST['preco']) ? $_POST['preco'] : '' ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="data_registro" class="form-label">Data de Registro:</label>
                        <input type="date" id="data_registro" name="data_registro" class="form-control" value="<?= isset($_POST['data_registro']) ? $_POST['data_registro'] : date('Y-m-d') ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <textarea id="descricao" name="descricao" class="form-control" rows="3"><?= isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : '' ?></textarea>
                    </div>
                </div>
            </div>
            
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

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Formatação do preço
            const precoInput = document.getElementById('preco');
            precoInput.addEventListener('blur', function() {
                if (this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        });
    </script>
</body>
</html>