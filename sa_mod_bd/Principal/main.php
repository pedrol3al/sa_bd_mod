<?php
session_start();
require_once("../Conexao/conexao.php");
require_once("../Financas/finance_functions.php");

// Verificar se usuário está logado
if (!isset($_SESSION['usuario'])){
    echo "<script>alert('Acesso negado!');window.location.href='../../index.php'</script>";
    exit;
}

$id_perfil = $_SESSION['perfil'];
$sqlPerfil = "SELECT perfil FROM perfil WHERE id_perfil =:id_perfil";
$stmtPerfil = $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(':id_perfil', $id_perfil);
$stmtPerfil->execute();
$perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil = $perfil['perfil'];

// Query para OS abertas (usando status correto)
$sqlOsAberta = "SELECT COUNT(*) AS total_abertas FROM ordens_servico WHERE status != 'Concluído'";
$stmt = $pdo->query($sqlOsAberta);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_abertas = $result['total_abertas'];

// Query para valor em aberto (usando função padronizada)
$valor_aberto = getPagamentosPendentes($pdo);
$valor_aberto_formatado = number_format($valor_aberto, 2, ',', '.');

// Query para OS concluídas no mês
$sqlOsConcluidas = "SELECT COUNT(*) AS total_concluidas 
                    FROM ordens_servico 
                    WHERE status = 'Concluído' 
                    AND MONTH(data_termino) = MONTH(CURRENT_DATE())
                    AND YEAR(data_termino) = YEAR(CURRENT_DATE())";
$stmt = $pdo->query($sqlOsConcluidas);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_concluidas = $result['total_concluidas'];

// Query para valor recebido no mês (usando função padronizada)
$valor_recebido = getReceitaTotal($pdo, 30); // Últimos 30 dias
$valor_recebido_formatado = number_format($valor_recebido, 2, ',', '.');

// Query para total de clientes
$sqlTotalClientes = "SELECT COUNT(*) AS total_clientes FROM cliente WHERE inativo = 0";
$stmt = $pdo->query($sqlTotalClientes);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_clientes = $result['total_clientes'];

// Query para total de técnicos
$sqlTotalTecnicos = "SELECT COUNT(*) AS total_tecnicos FROM usuario WHERE id_perfil = 3 AND inativo = 0";
$stmt = $pdo->query($sqlTotalTecnicos);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_tecnicos = $result['total_tecnicos'];

// Query para OS em andamento
$sqlOsAndamento = "SELECT COUNT(*) AS total_andamento FROM ordens_servico WHERE status = 'Em andamento'";
$stmt = $pdo->query($sqlOsAndamento);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_andamento = $result['total_andamento'];


?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Conserta Tech - Principal</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Link dos css -->
     <link rel="stylesheet" href="css_main.css"/>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css">
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">
</head>

<body>
    <?php include("../Menu_lateral/menu.php"); ?>

    <div class="dashboard-container">
        <!-- Seção de boas-vindas -->
        <div class="welcome-section">
            <h1>Conserta Tech</h1>
            <p>Bem-vindo(a), <?php echo $_SESSION["usuario"]; ?>! | Perfil: <?php echo $nome_perfil; ?></p>
        </div>
        
        <!-- Grid de estatísticas principais -->
        <div class="stats-grid">
            <div class="stat-card os-abertas">
                <h3>O.S. Abertas</h3>
                <div class="icon-container">
                    <i class="bi bi-clipboard-check" style="font-size: 1.5rem;"></i>
                </div>
                <div class="value"><?php echo $total_abertas; ?></div>
            </div>
            
            <div class="stat-card contas-receber">
                <h3>Valor em Aberto</h3>
                <div class="icon-container">
                    <i class="bi bi-currency-dollar" style="font-size: 1.5rem;"></i>
                </div>
                <div class="value">R$ <?php echo $valor_aberto; ?></div>
            </div>
            
            <div class="stat-card os-concluidas">
                <h3>O.S. Concluídas (Mês)</h3>
                <div class="icon-container">
                    <i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
                </div>
                <div class="value"><?php echo $total_concluidas; ?></div>
            </div>
            
            <div class="stat-card valor-recebido">
                <h3>Valor Recebido (Mês)</h3>
                <div class="icon-container">
                    <i class="bi bi-cash-coin" style="font-size: 1.5rem;"></i>
                </div>
                <div class="value">R$ <?php echo $valor_recebido; ?></div>
            </div>
            
            <div class="stat-card clientes">
                <h3>Total de Clientes</h3>
                <div class="icon-container">
                    <i class="bi bi-people" style="font-size: 1.5rem;"></i>
                </div>
                <div class="value"><?php echo $total_clientes; ?></div>
            </div>
        </div>
        
        <div class="metrics-section">
            <h2>Status das Ordens de Serviço</h2>
            <h2>Métricas gerais do sistema</h2>
            <div class="metrics-grid">
                <div class="metric-item os-andamento">
                    <h4>Ordens em Andamento</h4>
                    <div class="metric-value"><?php echo $total_andamento; ?></div>
                </div> 
                
                <div class="metric-item total-clientes">
                    <h4>Total Clientes</h4>
                    <div class="metric-value"><?php echo $total_clientes; ?></div>
                </div>
                
                <div class="metric-item total-tecnicos">
                    <h4>Técnicos Ativos</h4>
                    <div class="metric-value"><?php echo $total_tecnicos; ?></div>
                </div>
            </div>
        </div>
        
        <!-- Ações rápidas -->
        <div class="quick-actions">
            <h2>Ações Rápidas</h2>
            <div class="actions-grid">
                <a href="../Ordem_servico/os.php" class="action-item">
                    <div class="action-icon">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <div class="action-text">Nova OS</div>
                </a>
                
                <a href="../Cliente/cliente.php" class="action-item">
                    <div class="action-icon">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div class="action-text">Novo Cliente</div>
                </a>
                
                <a href="../Financas/pagamento_os.php" class="action-item">
                    <div class="action-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div class="action-text">Registrar Pagamento</div>
                </a>
                
                <a href="../Ordem_servico/buscar_os.php" class="action-item">
                    <div class="action-icon">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div class="action-text">Ver Todas as OS</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../Menu_lateral/carregar-menu.js"></script>
</body>
</html>