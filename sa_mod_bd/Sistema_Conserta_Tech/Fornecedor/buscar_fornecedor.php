<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3) {
    echo "Acesso Negado!";
    exit;
}

// Processar busca
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$fornecedores = [];

// Função auxiliar para evitar erros com valores nulos
function safe_html($value) {
    return $value !== null ? htmlspecialchars($value) : '';
}

try {
    $sql = "SELECT * FROM fornecedor WHERE 1=1";
    
    if (!empty($search)) {
        $sql .= " AND (";
        $sql .= "razao_social LIKE :search OR ";
        $sql .= "cnpj LIKE :search OR ";
        $sql .= "email LIKE :search OR ";
        $sql .= "produto_fornecido LIKE :search";
        $sql .= ")";
    }
    
    $sql .= " ORDER BY razao_social ASC";
    
    $stmt = $pdo->prepare($sql);
    
    if (!empty($search)) {
        $search_param = "%$search%";
        $stmt->bindParam(':search', $search_param);
    }
    
    $stmt->execute();
    $fornecedores = $stmt->fetchAll();
    
} catch (PDOException $e) {
    echo "Erro ao buscar fornecedores: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Fornecedores</title>
    
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
        
        .status-ativo {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-inativo {
            background-color: #f8d7da;
            color: #721c24;
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
            max-width: 800px;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>BUSCAR FORNECEDORES</h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <!-- Seção de busca -->
        <div class="search-section">
            <form method="GET" action="">
                <div class="search-container">
                    <input type="text" name="search" class="form-control search-input" 
                           placeholder="Buscar por razão social, CNPJ, email ou produto..." 
                           value="<?= safe_html($search) ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="buscar_fornecedor.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Limpar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Tabela de resultados -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-truck"></i> Fornecedores Encontrados
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Razão Social</th>
                                <th>CNPJ</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Produto Fornecido</th>
                                <th>Data Fundação</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($fornecedores) > 0): ?>
                                <?php foreach ($fornecedores as $fornecedor): 
                                    $status_class = $fornecedor['inativo'] == 1 ? 'status-inativo' : 'status-ativo';
                                    $status_text = $fornecedor['inativo'] == 1 ? 'Inativo' : 'Ativo';
                                ?>
                                <tr>
                                    <td><?= safe_html($fornecedor['id_fornecedor']) ?></td>
                                    <td><?= safe_html($fornecedor['razao_social']) ?></td>
                                    <td><?= safe_html($fornecedor['cnpj']) ?></td>
                                    <td><?= safe_html($fornecedor['email']) ?></td>
                                    <td><?= safe_html($fornecedor['telefone']) ?></td>
                                    <td><?= safe_html($fornecedor['produto_fornecido']) ?></td>
                                    <td><?= $fornecedor['data_fundacao'] ? date('d/m/Y', strtotime($fornecedor['data_fundacao'])) : 'N/A' ?></td>
                                    <td><span class="status-badge <?= $status_class ?>"><?= $status_text ?></span></td>
                                    <td class="actions">
                                        <a href="alterar_fornecedor.php?id=<?= safe_html($fornecedor['id_fornecedor']) ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Alterar
                                        </a>
                                        <!-- Botão de Informações Detalhadas -->
                                        <button class="btn btn-info btn-sm btn-detalhes" onclick="abrirModalDetalhes(<?= $fornecedor['id_fornecedor'] ?>)">
                                            <i class="bi bi-info-circle"></i> Detalhes
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="no-results">
                                        <i class="bi bi-search" style="font-size: 3rem;"></i>
                                        <h4>Nenhum fornecedor encontrado</h4>
                                        <p><?= !empty($search) ? 'Tente ajustar os termos da busca.' : 'Não há fornecedores cadastrados.' ?></p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes do Fornecedor -->
    <div class="modal-overlay" id="modalDetalhes">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Informações Detalhadas do Fornecedor</h3>
                <button class="modal-close" onclick="fecharModalDetalhes()">&times;</button>
            </div>
            <div class="modal-body" id="modalDetalhesBody">
                <!-- Conteúdo será carregado via JavaScript -->
                <div class="text-center p-4">Carregando informações do fornecedor...</div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
        // Dados dos fornecedores em formato JSON para uso no modal
        const fornecedoresData = <?php echo json_encode($fornecedores); ?>;

        // Funções para controlar o modal de detalhes
        function abrirModalDetalhes(idFornecedor) {
            // Encontrar o fornecedor com o ID correspondente
            const fornecedor = fornecedoresData.find(f => f.id_fornecedor == idFornecedor);
            
            if (fornecedor) {
                // Formatar a data de fundação para exibição
                const dataFundacao = formatarData(fornecedor.data_fundacao);
                const dataCadastro = formatarData(fornecedor.data_cadastro);
                
                // Formatar status para exibição
                const statusFormatado = fornecedor.inativo == 1 ? 'Inativo' : 'Ativo';
                
                // Construir o HTML do modal
                const modalHTML = `
                    <div class="info-section">
                        <h4>Dados do Fornecedor</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">ID:</span>
                                <span class="info-value">${escapeHtml(fornecedor.id_fornecedor)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Razão Social:</span>
                                <span class="info-value">${escapeHtml(fornecedor.razao_social)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">CNPJ:</span>
                                <span class="info-value">${fornecedor.cnpj ? escapeHtml(fornecedor.cnpj) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">${escapeHtml(fornecedor.email)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Telefone:</span>
                                <span class="info-value">${fornecedor.telefone ? escapeHtml(fornecedor.telefone) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Produto Fornecido:</span>
                                <span class="info-value">${escapeHtml(fornecedor.produto_fornecido)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Data de Fundação:</span>
                                <span class="info-value">${dataFundacao}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Data de Cadastro:</span>
                                <span class="info-value">${dataCadastro}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status:</span>
                                <span class="info-value">${statusFormatado}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4>Endereço</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">CEP:</span>
                                <span class="info-value">${fornecedor.cep ? escapeHtml(fornecedor.cep) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Logradouro:</span>
                                <span class="info-value">${fornecedor.logradouro ? escapeHtml(fornecedor.logradouro) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Número:</span>
                                <span class="info-value">${fornecedor.numero ? escapeHtml(fornecedor.numero) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Complemento:</span>
                                <span class="info-value">${fornecedor.complemento ? escapeHtml(fornecedor.complemento) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Bairro:</span>
                                <span class="info-value">${fornecedor.bairro ? escapeHtml(fornecedor.bairro) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Cidade:</span>
                                <span class="info-value">${fornecedor.cidade ? escapeHtml(fornecedor.cidade) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">UF:</span>
                                <span class="info-value">${fornecedor.uf ? escapeHtml(fornecedor.uf) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tipo de Estabelecimento:</span>
                                <span class="info-value">${fornecedor.tipo === 'R' ? 'Residencial' : (fornecedor.tipo === 'C' ? 'Comercial' : 'Não informado')}</span>
                            </div>
                        </div>
                    </div>
                    
                    ${fornecedor.observacoes ? `
                    <div class="info-section">
                        <h4>Observações</h4>
                        <div class="info-item">
                            <span class="info-value">${escapeHtml(fornecedor.observacoes)}</span>
                        </div>
                    </div>
                    ` : ''}
                `;
                
                // Inserir o HTML no modal
                document.getElementById('modalDetalhesBody').innerHTML = modalHTML;
            } else {
                document.getElementById('modalDetalhesBody').innerHTML = '<div class="alert alert-danger">Fornecedor não encontrado.</div>';
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