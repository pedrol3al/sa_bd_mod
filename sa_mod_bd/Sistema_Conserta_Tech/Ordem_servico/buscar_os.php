<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "Acesso Negado!";
    exit;
}

// Processar busca
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$ordens_servico = [];

try {
    $sql = "SELECT os.id, os.data_criacao, os.data_termino, os.status, 
                   c.nome as cliente_nome, c.id_cliente,
                   u.nome as tecnico_nome,
                   COALESCE(SUM(s.valor), 0) as valor_total,
                   COALESCE(SUM(p.valor_total), 0) as valor_pago
            FROM ordens_servico os
            INNER JOIN cliente c ON os.id_cliente = c.id_cliente
            INNER JOIN usuario u ON os.id_usuario = u.id_usuario
            LEFT JOIN equipamentos_os e ON os.id = e.id_os
            LEFT JOIN servicos_os s ON e.id = s.id_equipamento
            LEFT JOIN pagamento p ON os.id = p.id_os";
    
    if (!empty($search)) {
        $sql .= " WHERE (";
        $sql .= "c.nome = :search_exact OR "; // Busca exata
        $sql .= "c.nome LIKE CONCAT(:search_start, ' %') OR "; // Nome que começa com
        $sql .= "c.nome LIKE CONCAT('% ', :search_end) OR "; // Nome que termina com
        $sql .= "c.nome LIKE CONCAT('% ', :search_middle, ' %') OR "; // Nome que contém como palavra separada
        $sql .= "os.id = :search_id OR "; // ID exato
        $sql .= "os.status LIKE CONCAT('%', :search_status, '%')"; // Status parcial
        $sql .= ")";
    }
    
    $sql .= " GROUP BY os.id ORDER BY os.data_criacao DESC";
    
    $stmt = $pdo->prepare($sql);
    
    if (!empty($search)) {
        // Prepara os parâmetros para a busca
        $search_exact = $search;
        $search_start = $search;
        $search_end = $search;
        $search_middle = $search;
        $search_id = $search;
        $search_status = $search;
        
        // Bind dos parâmetros
        $stmt->bindParam(':search_exact', $search_exact);
        $stmt->bindParam(':search_start', $search_start);
        $stmt->bindParam(':search_end', $search_end);
        $stmt->bindParam(':search_middle', $search_middle);
        $stmt->bindParam(':search_id', $search_id);
        $stmt->bindParam(':search_status', $search_status);
    }
    
    $stmt->execute();
    $ordens_servico = $stmt->fetchAll();
    
} catch (PDOException $e) {
    echo "Erro ao buscar OS: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Ordens de Serviço</title>
    
    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    
    <style>
        .container {
            max-width: 1400px;
            margin: 20px 20px 20px 220px; /* Alterado: 220px na margem esquerda */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        
        h1 {
            margin-bottom: 30px;
            color: #2c3e50;
            text-align: center;
        }
        
        .search-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
            font-weight: bold;
        }
        
        .table-responsive {
            border-radius: 5px;
            overflow: hidden;
        }
        
        .table th {
            background-color: #4e73df;
            color: white;
            border: none;
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-aberto {
            background-color: #f8f9fa;
            color: #858796;
        }
        
        .status-andamento {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-pendente {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-concluido {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .actions {
            display: flex;
            gap: 5px;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .search-container {
            display: flex;
            gap: 10px;
        }
        
        .search-input {
            flex: 1;
        }
        
        .no-results {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
        
        /* Garantir que o menu lateral não sobreponha o conteúdo */
        @media (min-width: 768px) {
            body {
                overflow-x: hidden;
            }
        }
        
        /* Ajuste para telas menores */
        @media (max-width: 992px) {
            .container {
                margin-left: 20px;
                margin-right: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>BUSCAR ORDENS DE SERVIÇO</h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <!-- Seção de busca -->
        <div class="search-section">
            <form method="GET" action="">
                <div class="search-container">
                    <input type="text" name="search" class="form-control search-input" 
                           placeholder="Buscar por ID da OS, nome do cliente ou status..." 
                           value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="buscar_os.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Limpar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Tabela de resultados -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-list-check"></i> Ordens de Serviço Encontradas
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nº OS</th>
                                <th>Cliente</th>
                                <th>Técnico</th>
                                <th>Data Criação</th>
                                <th>Previsão Término</th>
                                <th>Status</th>
                                <th>Valor Total</th>
                                <th>Valor Pago</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($ordens_servico) > 0): ?>
                                <?php foreach ($ordens_servico as $os): 
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
                                <tr>
                                    <td><?= $os['id'] ?></td>
                                    <td><?= htmlspecialchars($os['cliente_nome']) ?></td>
                                    <td><?= htmlspecialchars($os['tecnico_nome']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($os['data_criacao'])) ?></td>
                                    <td><?= $os['data_termino'] ? date('d/m/Y', strtotime($os['data_termino'])) : 'N/A' ?></td>
                                    <td><span class="status-badge <?= $status_class ?>"><?= $os['status'] ?></span></td>
                                    <td>R$ <?= number_format($os['valor_total'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($os['valor_pago'], 2, ',', '.') ?></td>
                                    <td class="actions">
                                        <a href="alterar_os.php?id=<?= $os['id'] ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Alterar/Excluir
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="no-results">
                                        <i class="bi bi-search" style="font-size: 3rem;"></i>
                                        <h4>Nenhuma OS encontrada</h4>
                                        <p><?= !empty($search) ? 'Tente ajustar os termos da busca.' : 'Não há ordens de serviço cadastradas.' ?></p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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
        });
    </script>
</body>
</html>