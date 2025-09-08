<?php

include 'alterar_os_back.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Ordem de Serviço</title>
    
    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="alterar.css">

</head>
<body>
    <div class="container">
        <h1>ALTERAR ORDEM DE SERVIÇO #<?= $os['id'] ?></h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <form method="POST" action="">
            <input type="hidden" name="atualizar_os" value="1">
            
            <div class="form-section">
                <h2>Dados da OS</h2>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_cliente">Cliente:</label>
                            <select id="id_cliente" name="id_cliente" class="form-control" required>
                                <option value="">Selecione um cliente</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?= $cliente['id_cliente'] ?>" <?= $cliente['id_cliente'] == $os['id_cliente'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cliente['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_usuario">Técnico Responsável:</label>
                            <select id="id_usuario" name="id_usuario" class="form-control" required>
                                <option value="">Selecione um técnico</option>
                                <?php foreach ($tecnicos as $tecnico): ?>
                                    <option value="<?= $tecnico['id_usuario'] ?>" <?= $tecnico['id_usuario'] == $os['id_usuario'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tecnico['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_termino">Previsão de Término:</label>
                            <input type="date" id="data_termino" name="data_termino" class="form-control" 
                                   value="<?= $os['data_termino'] ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="aberto" <?= $os['status'] == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                                <option value="Em andamento" <?= $os['status'] == 'Em andamento' ? 'selected' : '' ?>>Em Andamento</option>
                                <option value="Pendente" <?= $os['status'] == 'Pendente' ? 'selected' : '' ?>>Aguardando Peças</option>
                                <option value="Concluído" <?= $os['status'] == 'Concluído' ? 'selected' : '' ?>>Concluído</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="observacoes">Observações:</label>
                            <textarea id="observacoes" name="observacoes" class="form-control" rows="3"><?= htmlspecialchars($os['observacoes']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Lista de equipamentos e serviços -->
            <?php if (count($equipamentos) > 0): ?>
            <div class="form-section">
                <h2>Equipamentos e Serviços</h2>
                
                <?php foreach ($equipamentos as $equipamento): ?>
                <div class="equipment-item">
                    <h5><?= htmlspecialchars($equipamento['fabricante']) ?> - <?= htmlspecialchars($equipamento['modelo']) ?></h5>
                    <p><strong>Nº Série:</strong> <?= htmlspecialchars($equipamento['num_serie']) ?></p>
                    <p><strong>Nº Aparelho:</strong> <?= htmlspecialchars($equipamento['num_aparelho']) ?></p>
                    <p><strong>Defeito:</strong> <?= htmlspecialchars($equipamento['defeito_reclamado']) ?></p>
                    <p><strong>Condição:</strong> <?= htmlspecialchars($equipamento['condicao']) ?></p>
                    
                    <?php if (isset($servicos_por_equipamento[$equipamento['id']]) && count($servicos_por_equipamento[$equipamento['id']]) > 0): ?>
                    <h6>Serviços realizados:</h6>
                    <?php foreach ($servicos_por_equipamento[$equipamento['id']] as $servico): ?>
                    <div class="service-item">
                        <p><strong>Tipo:</strong> <?= htmlspecialchars($servico['tipo_servico']) ?></p>
                        <p><strong>Descrição:</strong> <?= htmlspecialchars($servico['descricao']) ?></p>
                        <p><strong>Valor:</strong> R$ <?= number_format($servico['valor'], 2, ',', '.') ?></p>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- Lista de pagamentos -->
            <?php if (count($pagamentos) > 0): ?>
            <div class="form-section">
                <h2>Pagamentos</h2>
                
                <?php foreach ($pagamentos as $pagamento): ?>
                <div class="payment-item">
                    <div class="d-flex justify-content-between">
                        <h5>R$ <?= number_format($pagamento['valor_total'], 2, ',', '.') ?></h5>
                        <span class="status-badge status-<?= $pagamento['status'] == 'Concluído' ? 'pago' : 'pendente' ?>">
                            <?= $pagamento['status'] ?>
                        </span>
                    </div>
                    <p><strong>Forma:</strong> <?= htmlspecialchars($pagamento['frm_pagamento']) ?></p>
                    <p><strong>Data:</strong> 
                        <?= 
                            !empty($pagamento['data_pagamento']) 
                            ? date('d/m/Y', strtotime($pagamento['data_pagamento'])) 
                            : 'Data não informada' 
                        ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <div class="actions">
                <a href="buscar_os.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    <i class="bi bi-trash"></i> Excluir OS
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
                    <p>Tem certeza que deseja excluir esta Ordem de Serviço?</p>
                    <p class="text-danger"><strong>Esta ação não pode essere desfeita!</strong></p>
                    <p>Todos os dados relacionados (equipamentos, serviços e pagamentos) serão excluídos permanentemente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="alterar_os.php?id=<?= $id_os ?>&excluir_os=1" class="btn btn-danger">Excluir Permanentemente</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
       
            
            // Mostrar mensagens de sessão
            <?php if (isset($_SESSION['mensagem'])): ?>
                notyf.<?= $_SESSION['tipo_mensagem'] ?>('<?= $_SESSION['mensagem'] ?>');
                <?php
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>

            // Debug para verificar se o modal está sendo inicializado
            var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            
            // Adicionar evento de clique ao botão de excluir
            document.querySelector('[data-bs-target="#confirmDeleteModal"]').addEventListener('click', function() {
                myModal.show();
            });
        
    </script>
</body>
</html>