<?php
// buscar_os_frontend.php
// Inclui o backend primeiro para ter acesso às variáveis
include 'buscar_os_back.php';
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
    <link rel="stylesheet" href="buscar.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">
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
        const ordensServicoData = <?php echo $ordens_servico_json; ?>;

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

       // Configuração do Notyf 
const notyf = new Notyf({
    duration: 4000,
    position: {
        x: 'right',
        y: 'top'
    },
    types: [
        {
            type: 'success',
            background: '#28a745',
            icon: {
                className: 'bi bi-check-circle-fill',
                tagName: 'i',
                text: ''
            }
        },
        {
            type: 'error',
            background: '#dc3545',
            icon: {
                className: 'bi bi-x-circle-fill',
                tagName: 'i',
                text: ''
            }
        }
    ]
});


document.addEventListener('DOMContentLoaded', function() {
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