<?php
// Inclui o arquivo que processa as alterações do produto (lógica backend)
require_once 'processa_alteracao_produto.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 para suportar acentos e caracteres especiais -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura viewport para responsividade em dispositivos móveis -->
    <title>Alterar Produto</title> <!-- Título da página que aparece na aba do navegador -->

    <!-- Links para frameworks e bibliotecas CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> <!-- Bootstrap CSS local -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" /> <!-- Ícones do Bootstrap -->
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" /> <!-- CSS personalizado para o menu lateral -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"> <!-- Biblioteca de notificações toast -->

    <!-- CSS específico desta página -->
    <link rel="stylesheet" href="alterar.css">

    <!-- Favicon (ícone que aparece na aba do navegador) -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- Bootstrap 5 CSS via CDN (pode estar duplicado com o link local acima) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS via CDN (inclui Popper.js para componentes interativos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container"> <!-- Container principal do Bootstrap -->
        <h1>ALTERAR PRODUTO #<?= $produto['id_produto'] ?></h1> <!-- Título com o ID do produto -->

        <?php include("../Menu_lateral/menu.php"); ?> <!-- Inclui o menu lateral do sistema -->

        <form method="POST" action=""> <!-- Formulário para edição do produto (submete para a mesma página) -->
            <input type="hidden" name="atualizar_produto" value="1"> <!-- Campo oculto para identificar a ação de atualização -->

            <div class="form-section"> <!-- Seção de dados do produto -->
                <h2>Dados do Produto</h2>

                <div class="row mb-3"> <!-- Linha do formulário com duas colunas -->
                    <div class="col-md-6"> <!-- Coluna para seleção de fornecedor -->
                        <div class="form-group">
                            <label for="id_fornecedor" class="form-label">Fornecedor:</label>
                            <select id="id_fornecedor" name="id_fornecedor" class="form-control" required>
                                <option value="">Selecione um fornecedor</option>
                                <?php foreach ($fornecedores as $fornecedor): ?> <!-- Loop através de todos os fornecedores -->
                                    <option value="<?= $fornecedor['id_fornecedor'] ?>"
                                        <?= $fornecedor['id_fornecedor'] == $produto['id_fornecedor'] ? 'selected' : '' ?>>
                                        <!-- Marca como selecionado o fornecedor atual do produto -->
                                        <?= htmlspecialchars($fornecedor['razao_social']) ?> <!-- Exibe a razão social com escape HTML -->
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6"> <!-- Coluna para seleção do tipo de produto -->
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

                <div class="row mb-3"> <!-- Nova linha do formulário -->
                    <div class="col-md-6"> <!-- Coluna para nome do produto -->
                        <div class="form-group">
                            <label for="nome" class="form-label">Nome do Produto:</label>
                            <input type="text" id="nome" name="nome" class="form-control"
                                value="<?= htmlspecialchars($produto['nome']) ?>" required> <!-- Campo obrigatório -->
                        </div>
                    </div>

                    <div class="col-md-6"> <!-- Coluna para aparelho utilizado -->
                        <div class="form-group">
                            <label for="aparelho_utilizado" class="form-label">Aparelho Utilizado:</label>
                            <input type="text" id="aparelho_utilizado" name="aparelho_utilizado" class="form-control"
                                value="<?= htmlspecialchars($produto['aparelho_utilizado']) ?>"> <!-- Campo opcional -->
                        </div>
                    </div>
                </div>

                <div class="row mb-3"> <!-- Linha para quantidade e preço -->
                    <div class="col-md-6"> <!-- Coluna para quantidade -->
                        <div class="form-group">
                            <label for="quantidade" class="form-label">Quantidade:</label>
                            <input type="number" id="quantidade" name="quantidade" class="form-control" min="0"
                                value="<?= $produto['quantidade'] ?>" required> <!-- Não permite valores negativos -->
                        </div>
                    </div>

                    <div class="col-md-6"> <!-- Coluna para preço unitário -->
                        <div class="form-group">
                            <label for="preco" class="form-label">Preço Unitário (R$):</label>
                            <input type="number" id="preco" name="preco" class="form-control" step="0.01" min="0"
                                value="<?= $produto['preco'] ?>" required> <!-- Permite decimais com 2 casas -->
                        </div>
                    </div>
                </div>

                <div class="row mb-3"> <!-- Linha para data de registro -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_registro" class="form-label">Data de Registro:</label>
                            <input type="date" id="data_registro" name="data_registro" class="form-control"
                                value="<?= $produto['data_registro'] ?>"> <!-- Campo do tipo data -->
                        </div>
                    </div>
                </div>

                <div class="row mb-3"> <!-- Linha para descrição (ocupa toda a largura) -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descricao" class="form-label">Descrição:</label>
                            <textarea id="descricao" name="descricao" class="form-control"
                                rows="3"><?= htmlspecialchars($produto['descricao']) ?></textarea> <!-- Área de texto para descrição -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions"> <!-- Container para os botões de ação -->
                <a href="buscar_produto.php" class="btn btn-secondary"> <!-- Botão para voltar -->
                    <i class="bi bi-arrow-left"></i> Voltar <!-- Ícone e texto -->
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal"> <!-- Botão para abrir modal de exclusão -->
                    <i class="bi bi-trash"></i> Excluir Produto <!-- Ícone e texto -->
                </button>
                <button type="submit" class="btn btn-primary"> <!-- Botão para submeter o formulário -->
                    <i class="bi bi-check-circle"></i> Salvar Alterações <!-- Ícone e texto -->
                </button>
            </div>
        </form>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true"> <!-- Modal escondido que aparece ao clicar em excluir -->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"> <!-- Cabeçalho do modal -->
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Botão de fechar -->
                </div>
                <div class="modal-body"> <!-- Corpo do modal com mensagem de confirmação -->
                    <p>Tem certeza que deseja excluir este Produto?</p>
                    <p class="text-danger"><strong>Esta ação não pode ser desfeita!</strong></p> <!-- Alerta importante -->
                </div>
                <div class="modal-footer"> <!-- Rodapé do modal com botões de ação -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button> <!-- Botão para cancelar -->
                    <a href="buscar_produto.php?excluir_produto=1&id=<?= $id_produto ?>" class="btn btn-danger">Excluir
                        Permanentemente</a> <!-- Link para efetivar a exclusão -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts JavaScript -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS local -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script> <!-- Biblioteca de notificações -->

    <script>
        // Executa quando o documento HTML estiver totalmente carregado
        document.addEventListener('DOMContentLoaded', function () {
            // Configura e inicializa a biblioteca de notificações
            const notyf = new Notyf({
                position: { // Posição das notificações na tela
                    x: 'right',
                    y: 'top'
                },
                duration: 3000, // Duração de 3 segundos para exibir as notificações
                ripple: true, // Efeito visual de ripple
                dismissible: false // Não permite fechar as notificações clicando
            });

            // Mostrar mensagens de sessão (se existirem)
            <?php if (isset($_SESSION['mensagem'])): ?>
                notyf.<?= $_SESSION['tipo_mensagem'] === 'error' ? 'error' : 'success' ?>('<?= $_SESSION['mensagem'] ?>');
                <?php
                // Remove as mensagens da sessão após exibi-las para não mostrar novamente
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>

            // Formatação do preço - quando o campo perde o foco
            const precoInput = document.getElementById('preco');
            precoInput.addEventListener('blur', function () {
                if (this.value) {
                    // Formata o valor para ter sempre 2 casas decimais
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        });
    </script>
</body>

</html>