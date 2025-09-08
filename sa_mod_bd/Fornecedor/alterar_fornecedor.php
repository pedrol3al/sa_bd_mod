<?php
session_start();
require_once '../Conexao/conexao.php';

// Obter ID
$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_fornecedor === 0) {
    header('Location: buscar_fornecedor.php');
    exit;
}

// Buscar fornecedor
try {
    $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_fornecedor, PDO::PARAM_INT);
    $stmt->execute();
    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$fornecedor) {
        header('Location: buscar_fornecedor.php');
        exit;
    }
} catch (Exception $e) {
    die("Erro ao buscar fornecedor: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Fornecedor</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="alterar.css">

    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">
</head>
<body>
<div class="container">
    <h1>ALTERAR FORNECEDOR #<?= $id_fornecedor ?></h1>

    <?php include("../Menu_lateral/menu.php"); ?>

    <a href="buscar_fornecedor.php" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>

    <form id="formAlterarFornecedor" method="POST" action="processa_alteracao_fornecedor.php">
        <input type="hidden" id="id_fornecedor" name="id_fornecedor" value="<?= $id_fornecedor ?>">
        <input type="hidden" name="atualizar_fornecedor" value="1">

        <div class="form-section">
            <h2>Dados do Fornecedor</h2>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="razao_social" class="form-label">Razão Social:</label>
                    <input type="text" id="razao_social" name="razao_social" class="form-control" value="<?= htmlspecialchars($fornecedor['razao_social'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($fornecedor['email'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cnpj" class="form-label">CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" class="form-control cnpj-mask" value="<?= htmlspecialchars($fornecedor['cnpj'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label for="data_fundacao" class="form-label">Data de Fundação:</label>
                    <input type="date" id="data_fundacao" name="data_fundacao" class="form-control" value="<?= htmlspecialchars($fornecedor['data_fundacao'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="produto_fornecido" class="form-label">Produto Fornecido:</label>
                <input type="text" id="produto_fornecido" name="produto_fornecido" class="form-control" value="<?= htmlspecialchars($fornecedor['produto_fornecido'] ?? '') ?>">
            </div>
        </div>

        <div class="form-section">
            <h2>Endereço</h2>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="cep" class="form-label">CEP:</label>
                    <input type="text" id="cep" name="cep" class="form-control cep-mask" value="<?= htmlspecialchars($fornecedor['cep'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label for="logradouro" class="form-label">Logradouro:</label>
                    <input type="text" id="logradouro" name="logradouro" class="form-control" value="<?= htmlspecialchars($fornecedor['logradouro'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <input type="text" id="tipo" name="tipo" class="form-control" value="<?= htmlspecialchars($fornecedor['tipo'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="numero" class="form-label">Número:</label>
                    <input type="number" id="numero" name="numero" class="form-control" value="<?= htmlspecialchars($fornecedor['numero'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="complemento" class="form-label">Complemento:</label>
                    <input type="text" id="complemento" name="complemento" class="form-control" value="<?= htmlspecialchars($fornecedor['complemento'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="bairro" class="form-label">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" class="form-control" value="<?= htmlspecialchars($fornecedor['bairro'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="cidade" class="form-label">Cidade:</label>
                    <input type="text" id="cidade" name="cidade" class="form-control" value="<?= htmlspecialchars($fornecedor['cidade'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="uf" class="form-label">UF:</label>
                    <select id="uf" name="uf" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        $estados = ['AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO'];
                        $uf_atual = $fornecedor['uf'] ?? '';
                        foreach ($estados as $estado) {
                            $selected = ($estado == $uf_atual) ? 'selected' : '';
                            echo "<option value=\"$estado\" $selected>$estado</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="telefone" class="form-label">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" class="form-control phone-mask" value="<?= htmlspecialchars($fornecedor['telefone'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h2>Outras Informações</h2>
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações:</label>
                <textarea id="observacoes" name="observacoes" class="form-control" rows="3"><?= htmlspecialchars($fornecedor['observacoes'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="actions">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                <i class="bi bi-trash"></i> Excluir Fornecedor
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
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este Fornecedor?</p>
                <p class="text-danger"><strong>Esta ação não pode ser desfeita!</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="processa_alteracao_fornecedor.php?excluir_fornecedor=1&id=<?= $id_fornecedor ?>" class="btn btn-danger">Excluir Permanentemente</a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function () {
        const notyf = new Notyf({ position: { x: 'right', y: 'top' }, duration: 3000 });

        // Aplicar máscaras
        $('.cnpj-mask').mask('00.000.000/0000-00');
        $('.cep-mask').mask('00000-000');
        $('.phone-mask').mask('(00) 00000-0000');

        // Mostrar Notyf de sucesso se existir parâmetro
        <?php if (isset($_GET['success'])): ?>
        notyf.success('Fornecedor atualizado com sucesso!');
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
        notyf.error('<?= htmlspecialchars($_GET['error']) ?>');
        <?php endif; ?>
    });
</script>
</body>
</html>
