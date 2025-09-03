<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "Acesso Negado!";
    exit;
}

// Verificar se o ID foi passado
if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = 'ID do produto não especificado!';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: buscar_produto.php');
    exit;
}

$id_produto = $_GET['id'];

// Processar exclusão se solicitado
if (isset($_GET['excluir_produto'])) {
    try {
        // Verificar se o produto está vinculado a alguma OS antes de excluir
        $sql_check = "SELECT COUNT(*) as total FROM os_produto WHERE id_produto = :id_produto";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':id_produto', $id_produto);
        $stmt_check->execute();
        $result = $stmt_check->fetch();
        
        if ($result['total'] > 0) {
            $_SESSION['mensagem'] = 'Não é possível excluir este produto pois está vinculado a ordens de serviço!';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: alterar_produto.php?id=' . $id_produto);
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
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: alterar_produto.php?id=' . $id_produto);
        exit;
    }
}

// Buscar dados do produto
try {
    $sql = "SELECT p.*, f.razao_social as fornecedor_nome 
            FROM produto p 
            INNER JOIN fornecedor f ON p.id_fornecedor = f.id_fornecedor 
            WHERE p.id_produto = :id_produto";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_produto', $id_produto);
    $stmt->execute();
    $produto = $stmt->fetch();
    
    if (!$produto) {
        $_SESSION['mensagem'] = 'Produto não encontrado!';
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: buscar_produto.php');
        exit;
    }
    
    // Buscar fornecedores para o dropdown
    $sql_fornecedores = "SELECT id_fornecedor, razao_social FROM fornecedor WHERE inativo = 0 ORDER BY razao_social";
    $stmt_fornecedores = $pdo->prepare($sql_fornecedores);
    $stmt_fornecedores->execute();
    $fornecedores = $stmt_fornecedores->fetchAll();
    
} catch (PDOException $e) {
    echo "Erro ao carregar produto: " . $e->getMessage();
    exit;
}

// Processar atualização
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar_produto'])) {
    try {
        $id_fornecedor = $_POST['id_fornecedor'];
        $tipo = $_POST['tipo'];
        $nome = $_POST['nome'];
        $aparelho_utilizado = $_POST['aparelho_utilizado'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $data_registro = $_POST['data_registro'];
        $descricao = $_POST['descricao'];
        
        $sql_update = "UPDATE produto 
                       SET id_fornecedor = :id_fornecedor, 
                           tipo = :tipo, 
                           nome = :nome, 
                           aparelho_utilizado = :aparelho_utilizado, 
                           quantidade = :quantidade, 
                           preco = :preco, 
                           data_registro = :data_registro, 
                           descricao = :descricao 
                       WHERE id_produto = :id_produto";
        
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':id_fornecedor', $id_fornecedor);
        $stmt_update->bindParam(':tipo', $tipo);
        $stmt_update->bindParam(':nome', $nome);
        $stmt_update->bindParam(':aparelho_utilizado', $aparelho_utilizado);
        $stmt_update->bindParam(':quantidade', $quantidade);
        $stmt_update->bindParam(':preco', $preco);
        $stmt_update->bindParam(':data_registro', $data_registro);
        $stmt_update->bindParam(':descricao', $descricao);
        $stmt_update->bindParam(':id_produto', $id_produto);
        
        $stmt_update->execute();
        
        $_SESSION['mensagem'] = 'Produto atualizado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: alterar_produto.php?id=' . $id_produto);
        exit;
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao atualizar produto: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: alterar_produto.php?id=' . $id_produto);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Produto</title>
    
    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
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
        
        .btn-danger:hover {
            background-color: #c13526;
            border-color: #c13526;
        }
        
        .modal-content {
            border-radius: 10px;
            border: none;
        }
        
        .modal-header {
            background-color: #e74a3b;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        
        .modal-footer {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .container{
            margin-left: 200px !important;
        }
        
        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ALTERAR PRODUTO #<?= $produto['id_produto'] ?></h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <form method="POST" action="">
            <input type="hidden" name="atualizar_produto" value="1">
            
            <div class="form-section">
                <h2>Dados do Produto</h2>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_fornecedor" class="form-label">Fornecedor:</label>
                            <select id="id_fornecedor" name="id_fornecedor" class="form-control" required>
                                <option value="">Selecione um fornecedor</option>
                                <?php foreach ($fornecedores as $fornecedor): ?>
                                    <option value="<?= $fornecedor['id_fornecedor'] ?>" <?= $fornecedor['id_fornecedor'] == $produto['id_fornecedor'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($fornecedor['razao_social']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo" class="form-label">Tipo:</label>
                            <select id="tipo" name="tipo" class="form-control" required>
                                <option value="">Selecione o tipo</option>
                                <option value="Peça" <?= $produto['tipo'] == 'Peça' ? 'selected' : '' ?>>Peça</option>
                                <option value="Componente" <?= $produto['tipo'] == 'Componente' ? 'selected' : '' ?>>Componente</option>
                                <option value="Acessório" <?= $produto['tipo'] == 'Acessório' ? 'selected' : '' ?>>Acessório</option>
                                <option value="Material" <?= $produto['tipo'] == 'Material' ? 'selected' : '' ?>>Material</option>
                                <option value="Equipamento" <?= $produto['tipo'] == 'Equipamento' ? 'selected' : '' ?>>Equipamento</option>
                                <option value="Outro" <?= $produto['tipo'] == 'Outro' ? 'selected' : '' ?>>Outro</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome" class="form-label">Nome do Produto:</label>
                            <input type="text" id="nome" name="nome" class="form-control" 
                                   value="<?= htmlspecialchars($produto['nome']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aparelho_utilizado" class="form-label">Aparelho Utilizado:</label>
                            <input type="text" id="aparelho_utilizado" name="aparelho_utilizado" class="form-control" 
                                   value="<?= htmlspecialchars($produto['aparelho_utilizado']) ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantidade" class="form-label">Quantidade:</label>
                            <input type="number" id="quantidade" name="quantidade" class="form-control" 
                                   min="0" value="<?= $produto['quantidade'] ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="preco" class="form-label">Preço Unitário (R$):</label>
                            <input type="number" id="preco" name="preco" class="form-control" 
                                   step="0.01" min="0" value="<?= $produto['preco'] ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_registro" class="form-label">Data de Registro:</label>
                            <input type="date" id="data_registro" name="data_registro" class="form-control" 
                                   value="<?= $produto['data_registro'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descricao" class="form-label">Descrição:</label>
                            <textarea id="descricao" name="descricao" class="form-control" rows="3"><?= htmlspecialchars($produto['descricao']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="actions">
                <a href="buscar_produto.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    <i class="bi bi-trash"></i> Excluir Produto
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir este Produto?</p>
                    <p class="text-danger"><strong>Esta ação não pode ser desfeita!</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="alterar_produto.php?id=<?= $id_produto ?>&excluir_produto=1" class="btn btn-danger">Excluir Permanentemente</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notyf = new Notyf();
            
            // Mostrar mensagens de sessão
            <?php if (isset($_SESSION['mensagem'])): ?>
                notyf.<?= $_SESSION['tipo_mensagem'] ?>('<?= $_SESSION['mensagem'] ?>');
                <?php
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>

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