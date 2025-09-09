<?php

require_once 'processa_alteracao_produto.php';
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

    <!-- Css página -->
    <link rel="stylesheet" href="alterar.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



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
                                    <option value="<?= $fornecedor['id_fornecedor'] ?>"
                                        <?= $fornecedor['id_fornecedor'] == $produto['id_fornecedor'] ? 'selected' : '' ?>>
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
                                <option value="Componente" <?= $produto['tipo'] == 'Componente' ? 'selected' : '' ?>>
                                    Componente</option>
                                <option value="Acessório" <?= $produto['tipo'] == 'Acessório' ? 'selected' : '' ?>>
                                    Acessório</option>
                                <option value="Material" <?= $produto['tipo'] == 'Material' ? 'selected' : '' ?>>Material
                                </option>
                                <option value="Equipamento" <?= $produto['tipo'] == 'Equipamento' ? 'selected' : '' ?>>
                                    Equipamento</option>
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
                            <input type="number" id="quantidade" name="quantidade" class="form-control" min="0"
                                value="<?= $produto['quantidade'] ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="preco" class="form-label">Preço Unitário (R$):</label>
                            <input type="number" id="preco" name="preco" class="form-control" step="0.01" min="0"
                                value="<?= $produto['preco'] ?>" required>
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
                            <textarea id="descricao" name="descricao" class="form-control"
                                rows="3"><?= htmlspecialchars($produto['descricao']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <a href="buscar_produto.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal">
                    <i class="bi bi-trash"></i> Excluir Produto
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
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
                    <a href="buscar_produto.php?excluir_produto=1&id=<?= $id_produto ?>" class="btn btn-danger">Excluir
                        Permanentemente</a>
                </div>
            </div>
        </div>
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
                notyf.<?= $_SESSION['tipo_mensagem'] === 'error' ? 'error' : 'success' ?>('<?= $_SESSION['mensagem'] ?>');
                <?php
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>

            // Formatação do preço
            const precoInput = document.getElementById('preco');
            precoInput.addEventListener('blur', function () {
                if (this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        });
    </script>
</body>

</html>