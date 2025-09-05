<?php 
session_start();
require_once '../Conexao/conexao.php';

// verifica se o cliente tem permissão de adm ou atendente
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 4) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit();
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associar Pagamentos a OS</title>
    
    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    
    <style>
        .selected-row {
            background-color: #f8f9fa !important;
            font-weight: bold;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: white;
        }
        .status-aberto { background-color: #17a2b8; }
        .status-andamento { background-color: #ffc107; color: #000; }
        .status-pendente { background-color: #fd7e14; }
        .status-concluido { background-color: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ASSOCIAR PAGAMENTOS A ORDEM DE SERVIÇO</h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="bi bi-list-check"></i> Ordens de Serviço</div>
                <div class="search-container">
                    <form method="GET" action="" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2" 
                            placeholder="Buscar por cliente, OS ou status..." 
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-search"></i>
                        </button>
                        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                            <a href="pagamento_os.php" class="btn btn-secondary btn-sm ms-2">
                                <i class="bi bi-x-circle"></i> Limpar
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nº OS</th>
                                <th>Cliente</th>
                                <th>Responsável</th>
                                <th>Data Criação</th>
                                <th>Previsão Término</th>
                                <th>Status</th>
                                <th>Valor Total</th>
                                <th>Valor Pago</th>
                                <th>Selecionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Buscar OS do banco
                            require_once '../Conexao/conexao.php';
                            
                            try {
                                $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                                
                                $sql_os = "SELECT 
                                    os.id as id_os, 
                                    os.data_criacao, 
                                    os.data_termino, 
                                    os.status, 
                                    c.nome as cliente_nome, 
                                    u.nome as tecnico_nome,
                                    (SELECT COALESCE(SUM(s.valor), 0) 
                                    FROM equipamentos_os e 
                                    LEFT JOIN servicos_os s ON e.id = s.id_equipamento 
                                    WHERE e.id_os = os.id) as valor_total,
                                    (SELECT COALESCE(SUM(p.valor_total), 0) 
                                    FROM pagamento p 
                                    WHERE p.id_os = os.id AND p.status = 'Concluído') as valor_pago
                                FROM ordens_servico os
                                INNER JOIN cliente c ON os.id_cliente = c.id_cliente
                                INNER JOIN usuario u ON os.id_usuario = u.id_usuario";
                                
                                // Adicionar WHERE se houver pesquisa
                                if (!empty($search)) {
                                    $sql_os .= " WHERE (c.nome LIKE :search 
                                                OR os.id LIKE :search 
                                                OR os.status LIKE :search 
                                                OR u.nome LIKE :search)";
                                }
                                
                                $sql_os .= " GROUP BY os.id ORDER BY os.data_criacao DESC";
                                
                                $stmt_os = $pdo->prepare($sql_os);
                                
                                // Bind do parâmetro de pesquisa se existir
                                if (!empty($search)) {
                                    $searchParam = "%$search%";
                                    $stmt_os->bindParam(':search', $searchParam);
                                }
                                
                                $stmt_os->execute();
                                $ordens_servico = $stmt_os->fetchAll();
                                
                                // Mostrar mensagem se não encontrar resultados
                                if (empty($ordens_servico)) {
                                    echo "<tr><td colspan='9' class='text-center text-muted'>Nenhuma OS encontrada</td></tr>";
                                }
                                
                                foreach ($ordens_servico as $os) {
                                    $status_class = '';
                                    switch ($os['status']) {
                                        case 'aberto':
                                            $status_class = 'status-aberto';
                                            break;
                                        case 'Em andamento':
                                            $status_class = 'status-andamento';
                                            break;
                                        case 'Pendente':
                                            $status_class = 'status-pendente';
                                            break;
                                        case 'Concluído':
                                            $status_class = 'status-concluido';
                                            break;
                                    }
                            ?>
                            <tr data-os-id="<?= $os['id_os'] ?>">
                                <td><?= $os['id_os'] ?></td>
                                <td><?= htmlspecialchars($os['cliente_nome']) ?></td>
                                <td><?= htmlspecialchars($os['tecnico_nome']) ?></td>
                                <td><?= date('d/m/Y', strtotime($os['data_criacao'])) ?></td>
                                <td><?= $os['data_termino'] ? date('d/m/Y', strtotime($os['data_termino'])) : 'N/A' ?></td>
                                <td><span class="status-badge <?= $status_class ?>"><?= $os['status'] ?></span></td>
                                <td>R$ <?= number_format($os['valor_total'], 2, ',', '.') ?></td>
                                <td>R$ <?= number_format($os['valor_pago'], 2, ',', '.') ?></td>
                                <td class="text-center">
                                    <input type="radio" class="form-check-input" name="selected_os" value="<?= $os['id_os'] ?>">
                                </td>
                            </tr>
                            <?php
                                } // Fecha o foreach
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='9' class='text-center text-danger'>Erro ao carregar OS: " . $e->getMessage() . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="form-section" id="payment-section" style="display: none;">
            <h2>Registrar Pagamento</h2>
            
            <form id="payment-form" method="POST" action="processa_pagamento.php">
                <input type="hidden" id="id_os" name="id_os" value="">
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="valor_total_os">Valor Total da OS:</label>
                            <input type="text" id="valor_total_os" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="valor_pago">Valor Já Pago:</label>
                            <input type="text" id="valor_pago" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="saldo_restante">Saldo Restante:</label>
                            <input type="text" id="saldo_restante" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="valor_total">Valor do Pagamento *</label>
                            <input type="number" step="0.01" min="0.01" id="valor_total" name="valor_total" class="form-control" required>
                            <small class="form-text text-muted">Informe o valor que está sendo pago agora</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_pagamento">Data do Pagamento *</label>
                            <input type="date" id="data_pagamento" name="data_pagamento" class="form-control" required value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="frm_pagamento">Forma de Pagamento *</label>
                            <select id="frm_pagamento" name="frm_pagamento" class="form-control" required>
                                <option value="">Selecione...</option>
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                                <option value="Cartão de Débito">Cartão de Débito</option>
                                <option value="PIX">PIX</option>
                                <option value="Transferência">Transferência Bancária</option>
                                <option value="Boleto">Boleto</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status do Pagamento *</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="Pendente">Pendente</option>
                                <option value="Concluído" selected>Concluído</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Informação:</strong> Você pode registrar pagamentos parciais. 
                            O sistema irá somar automaticamente ao valor já pago.
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="cancel-payment">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-currency-dollar"></i> Registrar Pagamento
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notyf = new Notyf();
            const osRadios = document.querySelectorAll('input[name="selected_os"]');
            const paymentSection = document.getElementById('payment-section');
            const idOsInput = document.getElementById('id_os');
            const valorTotalOsInput = document.getElementById('valor_total_os');
            const valorPagoInput = document.getElementById('valor_pago');
            const saldoRestanteInput = document.getElementById('saldo_restante');
            const valorTotalInput = document.getElementById('valor_total');
            const cancelPaymentBtn = document.getElementById('cancel-payment');
            
            // Event listener para seleção de OS
            osRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const osId = this.value;
                        const osRow = this.closest('tr');
                        
                        // Obter valores da OS
                        const valorTotalOS = parseFloat(osRow.cells[6].textContent.replace('R$ ', '').replace('.', '').replace(',', '.'));
                        const valorPago = parseFloat(osRow.cells[7].textContent.replace('R$ ', '').replace('.', '').replace(',', '.'));
                        
                        // Preencher formulário
                        idOsInput.value = osId;
                        valorTotalOsInput.value = 'R$ ' + valorTotalOS.toFixed(2).replace('.', ',');
                        valorPagoInput.value = 'R$ ' + valorPago.toFixed(2).replace('.', ',');
                        
                        // Calcular saldo restante
                        const saldoRestante = valorTotalOS - valorPago;
                        saldoRestanteInput.value = 'R$ ' + saldoRestante.toFixed(2).replace('.', ',');
                        
                        // Sugerir valor do pagamento (saldo restante)
                        valorTotalInput.value = saldoRestante.toFixed(2);
                        
                        // Mostrar seção de pagamento
                        paymentSection.style.display = 'block';
                        
                        // Destacar linha selecionada
                        document.querySelectorAll('tr').forEach(row => {
                            row.classList.remove('selected-row');
                        });
                        osRow.classList.add('selected-row');
                        
                        // Scroll para a seção de pagamento
                        paymentSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
            
            // Cancelar pagamento
            cancelPaymentBtn.addEventListener('click', function() {
                paymentSection.style.display = 'none';
                document.querySelectorAll('input[name="selected_os"]').forEach(radio => {
                    radio.checked = false;
                });
                document.querySelectorAll('tr').forEach(row => {
                    row.classList.remove('selected-row');
                });
            });
            
            // Validação do formulário
            document.getElementById('payment-form').addEventListener('submit', function(e) {
                const valorTotalOS = parseFloat(valorTotalOsInput.value.replace('R$ ', '').replace('.', '').replace(',', '.'));
                const valorPago = parseFloat(valorPagoInput.value.replace('R$ ', '').replace('.', '').replace(',', '.'));
                const valorPagamento = parseFloat(valorTotalInput.value) || 0;
                
                if (valorPagamento <= 0) {
                    e.preventDefault();
                    notyf.error('O valor do pagamento deve ser maior que zero!');
                    return false;
                }
                
                // Verificar se o pagamento não excede o valor total da OS
                if ((valorPago + valorPagamento) > valorTotalOS) {
                    e.preventDefault();
                    notyf.error('O valor do pagamento excede o valor total da OS!');
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>