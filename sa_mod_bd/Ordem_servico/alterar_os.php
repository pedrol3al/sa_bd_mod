<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] !=3) {
  echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php'</script>";
  exit();
}


// Verificar se o ID foi passado
if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = 'ID da OS não especificado!';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: buscar_os.php');
    exit;
}

$id_os = $_GET['id'];

// Processar exclusão se solicitado
if (isset($_GET['excluir_os'])) {
    try {
        $pdo->beginTransaction();
        
        // Excluir serviços primeiro
        $sql_servicos = "DELETE servicos_os FROM servicos_os 
                         INNER JOIN equipamentos_os ON servicos_os.id_equipamento = equipamentos_os.id 
                         WHERE equipamentos_os.id_os = :id_os";
        $stmt_servicos = $pdo->prepare($sql_servicos);
        $stmt_servicos->bindParam(':id_os', $id_os);
        $stmt_servicos->execute();
        
        // Excluir equipamentos
        $sql_equipamentos = "DELETE FROM equipamentos_os WHERE id_os = :id_os";
        $stmt_equipamentos = $pdo->prepare($sql_equipamentos);
        $stmt_equipamentos->bindParam(':id_os', $id_os);
        $stmt_equipamentos->execute();
        
        // Excluir pagamentos
        $sql_pagamentos = "DELETE FROM pagamento WHERE id_os = :id_os";
        $stmt_pagamentos = $pdo->prepare($sql_pagamentos);
        $stmt_pagamentos->bindParam(':id_os', $id_os);
        $stmt_pagamentos->execute();
        
        // Excluir OS
        $sql_os = "DELETE FROM ordens_servico WHERE id = :id_os";
        $stmt_os = $pdo->prepare($sql_os);
        $stmt_os->bindParam(':id_os', $id_os);
        $stmt_os->execute();
        
        $pdo->commit();
        
        $_SESSION['mensagem'] = 'OS excluída com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: /sa_bd_mod/sa_mod_bd/Sistema_Conserta_Tech/Ordem_servico/buscar_os.php');
        exit;
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['mensagem'] = 'Erro ao excluir OS: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: alterar_os.php?id=' . $id_os);
        exit;
    }
}

// Buscar dados da OS
try {
    $sql_os = "SELECT os.*, c.nome as cliente_nome, c.id_cliente, u.nome as tecnico_nome, u.id_usuario
               FROM ordens_servico os
               INNER JOIN cliente c ON os.id_cliente = c.id_cliente
               INNER JOIN usuario u ON os.id_usuario = u.id_usuario
               WHERE os.id = :id_os";
    
    $stmt_os = $pdo->prepare($sql_os);
    $stmt_os->bindParam(':id_os', $id_os);
    $stmt_os->execute();
    $os = $stmt_os->fetch();
    
    if (!$os) {
        $_SESSION['mensagem'] = 'OS não encontrada!';
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: buscar_os.php');
        exit;
    }
    
    // Buscar equipamentos da OS
    $sql_equipamentos = "SELECT * FROM equipamentos_os WHERE id_os = :id_os";
    $stmt_equipamentos = $pdo->prepare($sql_equipamentos);
    $stmt_equipamentos->bindParam(':id_os', $id_os);
    $stmt_equipamentos->execute();
    $equipamentos = $stmt_equipamentos->fetchAll();
    
    // Buscar serviços dos equipamentos
    $servicos_por_equipamento = [];
    foreach ($equipamentos as $equipamento) {
        $sql_servicos = "SELECT * FROM servicos_os WHERE id_equipamento = :id_equipamento";
        $stmt_servicos = $pdo->prepare($sql_servicos);
        $stmt_servicos->bindParam(':id_equipamento', $equipamento['id']);
        $stmt_servicos->execute();
        $servicos_por_equipamento[$equipamento['id']] = $stmt_servicos->fetchAll();
    }
    
    // Buscar pagamentos da OS
    $sql_pagamentos = "SELECT * FROM pagamento WHERE id_os = :id_os ORDER BY data_pagamento DESC";
    $stmt_pagamentos = $pdo->prepare($sql_pagamentos);
    $stmt_pagamentos->bindParam(':id_os', $id_os);
    $stmt_pagamentos->execute();
    $pagamentos = $stmt_pagamentos->fetchAll();
    
    // Buscar clientes para o dropdown
    $sql_clientes = "SELECT id_cliente, nome FROM cliente WHERE inativo = 0 ORDER BY nome";
    $stmt_clientes = $pdo->prepare($sql_clientes);
    $stmt_clientes->execute();
    $clientes = $stmt_clientes->fetchAll();
    
    // Buscar técnicos para o dropdown
    $sql_tecnicos = "SELECT id_usuario, nome FROM usuario WHERE id_perfil = 3 AND inativo = 0 ORDER BY nome";
    $stmt_tecnicos = $pdo->prepare($sql_tecnicos);
    $stmt_tecnicos->execute();
    $tecnicos = $stmt_tecnicos->fetchAll();
    
} catch (PDOException $e) {
    echo "Erro ao carregar OS: " . $e->getMessage();
    exit;
}

// Processar atualização
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar_os'])) {
    try {
        $id_cliente = $_POST['id_cliente'];
        $id_usuario = $_POST['id_usuario'];
        $data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : null;
        $status = $_POST['status'];
        $observacoes = $_POST['observacoes'];
        
        $sql_update = "UPDATE ordens_servico 
                       SET id_cliente = :id_cliente, 
                           id_usuario = :id_usuario, 
                           data_termino = :data_termino, 
                           status = :status, 
                           observacoes = :observacoes 
                       WHERE id = :id_os";
        
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':id_cliente', $id_cliente);
        $stmt_update->bindParam(':id_usuario', $id_usuario);
        $stmt_update->bindParam(':data_termino', $data_termino);
        $stmt_update->bindParam(':status', $status);
        $stmt_update->bindParam(':observacoes', $observacoes);
        $stmt_update->bindParam(':id_os', $id_os);
        
        $stmt_update->execute();
        
        $_SESSION['mensagem'] = 'OS atualizada com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: alterar_os.php?id=' . $id_os);
        exit;
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao atualizar OS: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: alterar_os.php?id=' . $id_os);
        exit;
    }
}
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

    
    <style>
        .container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
            margin-left: 200px;
        }
        
        h1 {
            text-align: center;
            font-weight: bold;
            color: rgb(0, 0, 58);
            margin-bottom: 20px;
            font-family: 'Poppins' sans-serif
        }
        
        .form-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .equipment-list, .payment-list {
            margin-top: 20px;
        }
        
        .equipment-item, .payment-item {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            border-left: 4px solid #4e73df;
        }
        
        .service-item {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 3px;
            margin-top: 5px;
            margin-left: 20px;
        }
        
        .payment-item {
            border-left-color: #1cc88a;
        }
        
        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }
        
        .btn-danger:hover {
            background-color: #c13526;
            border-color: #c13526;
        }
        
        .modal-content {
            border-radius: 10px;
            border: none;
        }
        
        .modal-header {
            background-color: #e74a3b;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        
        .modal-footer {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-pago {
            background-color: #1cc88a;
            color: white;
        }
        
        .status-pendente {
            background-color: #f6c23e;
            color: #000;
        }

        .container{
            margin-left: 200px !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ALTERAR ORDEM DE SERViÇO #<?= $os['id'] ?></h1>
        
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
                    <p class="text-danger"><strong>Esta ação não pode ser desfeita!</strong></p>
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

            // Debug para verificar se o modal está sendo inicializado
            var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            
            // Adicionar evento de clique ao botão de excluir
            document.querySelector('[data-bs-target="#confirmDeleteModal"]').addEventListener('click', function() {
                myModal.show();
            });
        });
    </script>
</body>
</html>