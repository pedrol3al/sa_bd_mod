<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3){
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit();
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
$produtos = []; // Array para armazenar produtos

try {
    // Buscar clientes
    $sql_clientes = "SELECT id_cliente, nome FROM cliente WHERE inativo = 0 ORDER BY nome";
    $stmt_clientes = $pdo->prepare($sql_clientes);
    $stmt_clientes->execute();
    $clientes = $stmt_clientes->fetchAll();

    // Buscar técnicos (usuários com perfil 3)
    $sql_tecnicos = "SELECT id_usuario, nome FROM usuario WHERE id_perfil=3 AND inativo = 0 ORDER BY nome";
    $stmt_tecnicos = $pdo->prepare($sql_tecnicos);
    $stmt_tecnicos->execute();
    $tecnicos = $stmt_tecnicos->fetchAll();
    
    // Buscar produtos ativos em estoque (apenas os com quantidade > 0)
    // CORREÇÃO: Removida a coluna 'inativo' que não existe na tabela produto
    $sql_produtos = "SELECT id_produto, nome, quantidade FROM produto WHERE quantidade > 0 ORDER BY nome";
    $stmt_produtos = $pdo->prepare($sql_produtos);
    $stmt_produtos->execute();
    $produtos = $stmt_produtos->fetchAll();

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
                            <option value="Em andamento">Em Andamento</option>
                            <option value="Pendente">Aguardando Peças</option>
                            <option value="Concluído">Concluído</option>
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
                    <!-- Os equipamentos são adicionados dinamicamente aqui -->
                </div>
            </div>
            
            <div class="actions mt-4">
            <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Salvar Ordem de Serviço
                </button>
                <button type="button" class="btn btn-danger" onclick=" window.history.back() ">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>

            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        // Configuração do Flatpickr para datas
        flatpickr("#data_termino", {
            dateFormat: "Y-m-d",
            minDate: "today",
            locale: "pt"
        });


        let equipmentCount = 0;
        // Array de produtos disponíveis em estoque (para uso no JavaScript)
        const produtos = <?php echo json_encode($produtos); ?>;

        document.getElementById('add-equipment').addEventListener('click', function() {
            addEquipment();
        });

        function addEquipment() {
            const equipmentContainer = document.getElementById('equipment-container');
            const equipmentIndex = equipmentContainer.children.length;
            
            const equipmentDiv = document.createElement('div');
            equipmentDiv.className = 'equipment-item card mb-3';
            equipmentDiv.innerHTML = `
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Equipamento #${equipmentIndex + 1}</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-equipment">
                        <i class="bi bi-trash"></i> Remover
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Fabricante:</label>
                            <input type="text" name="equipamentos[${equipmentIndex}][fabricante]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Modelo:</label>
                            <input type="text" name="equipamentos[${equipmentIndex}][modelo]" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Número de Série:</label>
                            <input type="number" name="equipamentos[${equipmentIndex}][num_serie]" class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Número do Aparelho:</label>
                            <input type="number" name="equipamentos[${equipmentIndex}][num_aparelho]" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Defeito Reclamado:</label>
                            <textarea name="equipamentos[${equipmentIndex}][defeito_reclamado]" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Condição do Equipamento:</label>
                            <textarea name="equipamentos[${equipmentIndex}][condicao]" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="services-section mt-3">
                        <h6>Serviços para este equipamento</h6>
                        <button type="button" class="btn btn-sm btn-success add-service-btn">
                            <i class="bi bi-plus"></i> Adicionar Serviço
                        </button>
                        <div class="service-list mt-2" id="service-list-${equipmentIndex}">
                            
                        </div>
                    </div>
                </div>
            `;
            
            equipmentContainer.appendChild(equipmentDiv);
            
            // Adicionar evento para remover equipamento
            equipmentDiv.querySelector('.remove-equipment').addEventListener('click', function() {
                if (equipmentContainer.children.length > 1) {
                    equipmentContainer.removeChild(equipmentDiv);
                    // Renumerar os equipamentos
                    Array.from(equipmentContainer.children).forEach((item, index) => {
                        item.querySelector('h5').textContent = `Equipamento #${index + 1}`;
                    });
                } else {
                    alert('É necessário ter pelo menos um equipamento.');
                }
            });
            
            // Adicionar evento para adicionar serviços
            equipmentDiv.querySelector('.add-service-btn').addEventListener('click', function() {
                addService(equipmentIndex);
            });
            
            // Adicionar um serviço inicial
            addService(equipmentIndex);
        }

        function addService(equipmentIndex) {
            const serviceList = document.getElementById(`service-list-${equipmentIndex}`);
            const serviceIndex = serviceList.children.length;
            
            const serviceItem = document.createElement('div');
            serviceItem.className = 'service-item border p-2 mb-2';
            serviceItem.innerHTML = `
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][tipo_servico]" 
                               class="form-control form-control-sm" placeholder="Tipo de serviço" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][descricao]" 
                               class="form-control form-control-sm" placeholder="Descrição">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="number" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][valor]" 
                               class="form-control form-control-sm" placeholder="Valor R$" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][id_produto]" 
                                class="form-control form-control-sm">
                            <option value="">Peça utilizada (opcional)</option>
                            ${produtos.map(produto => 
                                `<option value="${produto.id_produto}">
                                    ${produto.nome} (Estoque: ${produto.quantidade})
                                </option>`
                            ).join('')}
                        </select>
                    </div>
                    <div class="col-md-1 mb-2">
                        <button type="button" class="btn btn-sm btn-danger remove-service">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            `;

            // Adicione este código JavaScript ao seu arquivo
function addService(equipmentIndex) {
    const serviceList = document.getElementById(`service-list-${equipmentIndex}`);
    const serviceIndex = serviceList.children.length;
    
    const serviceItem = document.createElement('div');
    serviceItem.className = 'service-item border p-2 mb-2';
    serviceItem.innerHTML = `
        <div class="row">
            <div class="col-md-3 mb-2">
                <input type="text" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][tipo_servico]" 
                       class="form-control form-control-sm" placeholder="Tipo de serviço" required>
            </div>
            <div class="col-md-3 mb-2">
                <input type="text" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][descricao]" 
                       class="form-control form-control-sm" placeholder="Descrição">
            </div>
            <div class="col-md-2 mb-2">
                <input type="number" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][valor]" 
                       class="form-control form-control-sm" placeholder="Valor R$" step="0.01" min="0" required>
            </div>
            <div class="col-md-3 mb-2">
                <select name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][id_produto]" 
                        class="form-control form-control-sm product-select" 
                        onchange="updateStockInfo(this)">
                    <option value="">Peça utilizada (opcional)</option>
                    ${produtos.map(produto => 
                        `<option value="${produto.id_produto}" data-stock="${produto.quantidade}">
                            ${produto.nome} (Estoque: ${produto.quantidade})
                        </option>`
                    ).join('')}
                </select>
                <small class="stock-info text-muted"></small>
            </div>
            <div class="col-md-1 mb-2">
                <button type="button" class="btn btn-sm btn-danger remove-service">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    `;
    
    serviceList.appendChild(serviceItem);
    
    // Adicionar evento para remover serviço
    serviceItem.querySelector('.remove-service').addEventListener('click', function() {
        serviceList.removeChild(serviceItem);
    });
}

// Função para mostrar informações de estoque
function updateStockInfo(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const stockInfo = selectElement.parentElement.querySelector('.stock-info');
    const stock = selectedOption.getAttribute('data-stock');
    
    if (selectedOption.value && stock) {
        if (stock <= 0) {
            stockInfo.innerHTML = '<span class="text-danger">Sem estoque!</span>';
            selectElement.value = '';
        } else if (stock <= 3) {
            stockInfo.innerHTML = `<span class="text-warning">Baixo estoque: ${stock} unidades</span>`;
        } else {
            stockInfo.innerHTML = `<span class="text-success">Estoque: ${stock} unidades</span>`;
        }
    } else {
        stockInfo.innerHTML = '';
    }
}

// Validar estoque antes de enviar o formulário
document.getElementById('os-form').addEventListener('submit', function(e) {
    const productSelects = document.querySelectorAll('.product-select');
    let hasStockIssue = false;
    
    productSelects.forEach(select => {
        if (select.value) {
            const selectedOption = select.options[select.selectedIndex];
            const stock = parseInt(selectedOption.getAttribute('data-stock'));
            
            if (stock <= 0) {
                hasStockIssue = true;
                select.style.borderColor = 'red';
                alert(`O produto "${selectedOption.text}" não está disponível em estoque!`);
            }
        }
    });
    
    if (hasStockIssue) {
        e.preventDefault();
    }
});
            
            serviceList.appendChild(serviceItem);
            
            // Adicionar evento para remover serviço
            serviceItem.querySelector('.remove-service').addEventListener('click', function() {
                serviceList.removeChild(serviceItem);
            });
        }

        // Adicionar primeiro equipamento ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            addEquipment();
        });


    </script>
</body>
</html>