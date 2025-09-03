<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3) {
    echo "Acesso Negado!";
    exit;
}

if (isset($_SESSION['notyf_message'])) {
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        const notyf = new Notyf({
            duration: ' . ($_SESSION['notyf_duration'] ?? 5000) . ',
            position: {
                x: "right",
                y: "top"
            },
            types: [
                {
                    type: "success",
                    background: "#28a745",
                    icon: {
                        className: "bi bi-check-circle",
                        tagName: "i",
                        text: ""
                    }
                },
                {
                    type: "error",
                    background: "#dc3545",
                    icon: {
                        className: "bi bi-x-circle",
                        tagName: "i",
                        text: ""
                    }
                }
            ]
        });
        
        notyf.' . $_SESSION['notyf_type'] . '("' . addslashes($_SESSION['notyf_message']) . '");
    });
    </script>';
    
    // Limpar a mensagem da sessão
    unset($_SESSION['notyf_message'], $_SESSION['notyf_type'], $_SESSION['notyf_duration']);
}

// Buscar clientes do banco
$clientes = [];
$tecnicos = [];

try {
    // Buscar clientes
    $sql_clientes = "SELECT id_cliente, nome FROM cliente WHERE inativo = 0 ORDER BY nome";
    $stmt_clientes = $pdo->prepare($sql_clientes);
    $stmt_clientes->execute();
    $clientes = $stmt_clientes->fetchAll();

    // Buscar técnicos (usuários com perfil 3)
    $sql_tecnicos = "SELECT id_usuario, nome FROM usuario WHERE id_perfil = 3 AND inativo = 0 ORDER BY nome";
    $stmt_tecnicos = $pdo->prepare($sql_tecnicos);
    $stmt_tecnicos->execute();
    $tecnicos = $stmt_tecnicos->fetchAll();

} catch (PDOException $e) {
    echo "Erro ao carregar dados: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Ordens de Serviço</title>

      <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css_os.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>
<body>
    <div class="container">
        <h1>CADASTRO DE ORDENS DE SERVIÇO</h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <form id="os-form" method="POST" action="cadastro_os.php">
            <div class="form-section">
                <h2>Dados do Cliente</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_cliente">Cliente:</label>
                        <select id="id_cliente" name="id_cliente" class="form-control" required>
                            <option value="">Selecione um cliente</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id_cliente'] ?>"><?= htmlspecialchars($cliente['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_usuario">Responsável:</label>
                        <select id="id_usuario" name="id_usuario" class="form-control" required>
                            <option value="">Selecione um técnico</option>
                            <?php foreach ($tecnicos as $tecnico): ?>
                                <option value="<?= $tecnico['id_usuario'] ?>"><?= htmlspecialchars($tecnico['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="data_termino">Previsão de Término:</label>
                        <input type="date" id="data_termino" name="data_termino" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="aberto">Aberto</option>
                            <option value="andamento">Em Andamento</option>
                            <option value="aguardando">Aguardando Peças</option>
                            <option value="concluido">Concluído</option>
                            <option value="entregue">Entregue</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="observacoes">Observações Gerais:</label>
                        <textarea id="observacoes" name="observacoes" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Equipamentos</h2>
                
                <button type="button" class="btn btn-primary add-btn" id="add-equipment">
                    <i class="bi bi-plus-circle"></i> Adicionar Equipamento
                </button>
                
                <div id="equipment-container">
                    <!-- Os equipamentos serão adicionados dinamicamente aqui -->
                </div>
            </div>
            
            <div class="actions mt-4">
                <button type="button" class="btn btn-danger" onclick="window.history.back()">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Salvar Ordem de Serviço
                </button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="os.js"></script>
</body>
</html>