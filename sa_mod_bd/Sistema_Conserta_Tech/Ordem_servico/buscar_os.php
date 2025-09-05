<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] !=3) {
  echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php'</script>";
  exit();
}


// Processar busca
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$ordens_servico = [];

// Função auxiliar para evitar erros com valores nulos
function safe_html($value) {
    return $value !== null ? htmlspecialchars($value) : '';
}

try {
    $sql = "SELECT os.id, os.data_criacao, os.data_termino, os.status, 
                   c.nome as cliente_nome, c.id_cliente, c.telefone as cliente_telefone,
                   u.nome as tecnico_nome, u.id_usuario,
                   COALESCE(SUM(s.valor), 0) as valor_total,
                   COALESCE(SUM(p.valor_total), 0) as valor_pago,
                   os.observacoes
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
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --background-color: #ecf0f1;
            --text-color: #2c3e50;
            --border-color: #bdc3c7;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 20px 20px 20px 220px;
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
        
        .btn-info {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        
        .btn-info:hover {
            background-color: #2980b9;
            border-color: #2980b9;
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
        
        .prioridade-alta {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .prioridade-media {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .prioridade-baixa {
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
        
        /* Modal de Detalhes Estilizado */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 10px;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s;
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        
        .modal-header h3 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .info-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .info-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .info-section h4 {
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--secondary-color);
            display: inline-block;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 12px;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 4px;
            font-size: 0.9rem;
        }
        
        .info-value {
            color: #555;
            background-color: #f9f9f9;
            padding: 8px 12px;
            border-radius: 5px;
            border-left: 3px solid var(--secondary-color);
        }
        
        /* Botão de detalhes personalizado */
        .btn-detalhes {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }
        
        .btn-detalhes:hover {
            background-color: #2980b9;
            color: white;
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
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .actions {
                flex-direction: column;
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
                           value="<?= safe_html($search) ?>">
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
                                    <td><?= safe_html($os['cliente_nome']) ?></td>
                                    <td><?= safe_html($os['tecnico_nome']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($os['data_criacao'])) ?></td>
                                    <td><?= $os['data_termino'] ? date('d/m/Y', strtotime($os['data_termino'])) : 'N/A' ?></td>
                                    <td><span class="status-badge <?= $status_class ?>"><?= $os['status'] ?></span></td>
                                    <td>R$ <?= number_format($os['valor_total'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($os['valor_pago'], 2, ',', '.') ?></td>
                                    <td class="actions">
                                        <!-- Botão de Informações Detalhadas -->
                                        <button class="btn btn-info btn-sm btn-detalhes" onclick="abrirModalDetalhes(<?= $os['id'] ?>)">
                                            <i class="bi bi-info-circle"></i> Detalhes
                                        </button>
                                        
                                        <!-- Botão de alterar/excluir -->
                                        <a href="alterar_os.php?id=<?= $os['id'] ?>" class="btn btn-primary btn-sm" title="Alterar/Excluir">
                                            <i class="bi bi-pencil"></i> Alterar
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

    <!-- Modal de Detalhes da OS -->
    <div class="modal-overlay" id="modalDetalhes">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Informações Detalhadas da OS</h3>
                <button class="modal-close" onclick="fecharModalDetalhes()">&times;</button>
            </div>
            <div class="modal-body" id="modalDetalhesBody">
                <!-- Conteúdo será carregado via JavaScript -->
                <div class="text-center p-4">Carregando informações da OS...</div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
        // Dados das OS em formato JSON para uso no modal
        const ordensServicoData = <?php echo json_encode($ordens_servico); ?>;

        // Funções para controlar o modal de detalhes
        function abrirModalDetalhes(idOS) {
            // Encontrar a OS com o ID correspondente
            const os = ordensServicoData.find(o => o.id == idOS);
            
            if (os) {
                // Formatar as datas para exibição
                const dataCriacao = formatarData(os.data_criacao);
                const dataTermino = formatarData(os.data_termino);
                
                // Formatar valores monetários
                const valorTotal = formatarMoeda(os.valor_total);
                const valorPago = formatarMoeda(os.valor_pago);
                const valorRestante = formatarMoeda(os.valor_total - os.valor_pago);
                
                // Formatar prioridade
                let prioridadeFormatada = 'Não informada';
                let prioridadeClass = '';
                
                if (os.prioridade) {
                    switch (os.prioridade.toLowerCase()) {
                        case 'alta':
                            prioridadeFormatada = 'Alta';
                            prioridadeClass = 'prioridade-alta';
                            break;
                        case 'media':
                            prioridadeFormatada = 'Média';
                            prioridadeClass = 'prioridade-media';
                            break;
                        case 'baixa':
                            prioridadeFormatada = 'Baixa';
                            prioridadeClass = 'prioridade-baixa';
                            break;
                        default:
                            prioridadeFormatada = os.prioridade;
                    }
                }
                
                // Construir o HTML do modal
                const modalHTML = `
                    <div class="info-section">
                        <h4>Dados da Ordem de Serviço</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Nº OS:</span>
                                <span class="info-value">${escapeHtml(os.id)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status:</span>
                                <span class="info-value">${escapeHtml(os.status)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Data de Criação:</span>
                                <span class="info-value">${dataCriacao}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Previsão de Término:</span>
                                <span class="info-value">${dataTermino}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Prioridade:</span>
                                <span class="info-value ${prioridadeClass}">${prioridadeFormatada}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4>Dados do Cliente</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Cliente:</span>
                                <span class="info-value">${escapeHtml(os.cliente_nome)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">ID Cliente:</span>
                                <span class="info-value">${escapeHtml(os.id_cliente)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Telefone:</span>
                                <span class="info-value">${os.cliente_telefone ? escapeHtml(os.cliente_telefone) : 'Não informado'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4>Dados do Técnico</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Técnico Responsável:</span>
                                <span class="info-value">${escapeHtml(os.tecnico_nome)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">ID Técnico:</span>
                                <span class="info-value">${escapeHtml(os.id_usuario)}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4>Valores</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Valor Total:</span>
                                <span class="info-value">R$ ${valorTotal}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Valor Pago:</span>
                                <span class="info-value">R$ ${valorPago}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Valor Restante:</span>
                                <span class="info-value">R$ ${valorRestante}</span>
                            </div>
                        </div>
                    </div>
                    
                    ${os.observacoes ? `
                    <div class="info-section">
                        <h4>Observações</h4>
                        <div class="info-item">
                            <span class="info-value">${escapeHtml(os.observacoes)}</span>
                        </div>
                    </div>
                    ` : ''}
                `;
                
                // Inserir o HTML no modal
                document.getElementById('modalDetalhesBody').innerHTML = modalHTML;
            } else {
                document.getElementById('modalDetalhesBody').innerHTML = '<div class="alert alert-danger">Ordem de Serviço não encontrada.</div>';
            }
            
            // Mostrar o modal
            document.getElementById('modalDetalhes').style.display = 'flex';
        }

        function fecharModalDetalhes() {
            document.getElementById('modalDetalhes').style.display = 'none';
        }

        // Função para formatar data (de YYYY-MM-DD para DD/MM/YYYY)
        function formatarData(data) {
            if (!data) return 'Não informado';
            
            const partes = data.split('-');
            if (partes.length === 3) {
                return `${partes[2]}/${partes[1]}/${partes[0]}`;
            }
            return data;
        }
        
        // Função para formatar valor monetário
        function formatarMoeda(valor) {
            if (!valor) return '0,00';
            return parseFloat(valor).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Função para escapar HTML (prevenir XSS)
        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Fechar modal ao clicar fora do conteúdo
        document.getElementById('modalDetalhes').addEventListener('click', function(e) {
            if (e.target === this) {
                fecharModalDetalhes();
            }
        });

        // Fechar modal com a tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                fecharModalDetalhes();
            }
        });

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