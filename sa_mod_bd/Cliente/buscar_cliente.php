<?php
session_start();
require_once '../Conexao/conexao.php';

// verifica se o cliente tem permissão de adm ou atendente
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit();
}

$clientes = []; // inicializa a variavel

// Se o formulário for enviado, busca o cliente pelo id ou nome
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca_cliente'])) {
    $busca = trim($_POST['busca_cliente']);

    if (is_numeric($busca)) {
        $sql = "SELECT * FROM cliente WHERE id_cliente = :busca ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM cliente WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR); // busca em qualquer posição
    }
} else {
    // Se não enviou busca, lista todos
    $sql = "SELECT * FROM cliente ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se um GET com id for passado, busca os dados do cliente
$clienteAtual = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_cliente = $_GET['id'];
    $sql = "SELECT * FROM cliente WHERE id_cliente = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    $clienteAtual = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Atualização do cliente
if (isset($_POST['id_cliente'], $_POST['nome'], $_POST['email'])) {
    $id_cliente = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "UPDATE cliente SET nome = :nome, email = :email WHERE id_cliente = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Cliente alterado com sucesso!');window.location.href='alterar_cliente.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao alterar o cliente!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar cliente</title>

    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <link rel="stylesheet" href="buscar.css">


</head>

<body>
    <div class="container">
        <h1>BUSCAR CLIENTES</h1>

        <?php include("../Menu_lateral/menu.php"); ?>

        <!-- Seção de busca -->
        <div class="search-section">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="busca_cliente" class="form-label fw-bold">Digite o ID ou Nome do cliente:</label>
                    <div class="search-container">
                        <input type="text" id="busca_cliente" name="busca_cliente" class="form-control search-input"
                            placeholder="Ex: 12 ou João"
                            value="<?= isset($_POST['busca_cliente']) ? htmlspecialchars($_POST['busca_cliente']) : '' ?>"
                            required>
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabela de resultados -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-people-fill"></i> Clientes Encontrados
            </div>
            <div class="card-body">
                <?php if (!empty($clientes)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Observação</th>
                                    <th>Data de Nascimento</th>
                                    <th>Sexo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $cliente): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                                        <td><?= !empty($cliente['observacao']) ? htmlspecialchars($cliente['observacao']) : 'Nenhuma' ?>
                                        </td>
                                        <td><?= htmlspecialchars($cliente['data_nasc']) ?></td>
                                        <td>
                                            <?php
                                            switch ($cliente['sexo']) {
                                                case 'M':
                                                    echo 'Masculino';
                                                    break;
                                                case 'F':
                                                    echo 'Feminino';
                                                    break;
                    
                                                default:
                                                    echo htmlspecialchars($cliente['sexo']);
                                            }
                                            ?>
                                        </td>
                                        <td class="actions">
                                            <a class="btn btn-warning btn-sm"
                                                href="alterar_cliente.php?id=<?= htmlspecialchars($cliente['id_cliente']) ?>">
                                                <i class="bi bi-pencil"></i> Alterar
                                            </a>
                                            <!-- Botão de Informações Detalhadas -->
                                            <button class="btn btn-info btn-sm btn-detalhes"
                                                onclick="abrirModalDetalhes(<?= $cliente['id_cliente'] ?>)">
                                                <i class="bi bi-info-circle"></i> Detalhes
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-results">
                        <i class="bi bi-search" style="font-size: 3rem;"></i>
                        <h4>Nenhum cliente encontrado</h4>
                        <p><?= isset($_POST['busca_cliente']) ? 'Tente ajustar os termos da busca.' : 'Não há clientes cadastrados.' ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes do Cliente -->
    <div class="modal-overlay" id="modalDetalhes">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Informações Detalhadas do Cliente</h3>
                <button class="modal-close" onclick="fecharModalDetalhes()">&times;</button>
            </div>
            <div class="modal-body" id="modalDetalhesBody">
                <!-- Conteúdo será carregado via JavaScript -->
                <div class="text-center p-4">Carregando informações do cliente...</div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Dados dos clientes em formato JSON para uso no modal
        const clientesData = <?php echo json_encode($clientes); ?>;

        // Funções para controlar o modal de detalhes
        function abrirModalDetalhes(idCliente) {
            // Encontrar o cliente com o ID correspondente
            const cliente = clientesData.find(c => c.id_cliente == idCliente);

            if (cliente) {
                // Formatar as datas para exibição
                const dataNasc = formatarData(cliente.data_nasc);
                const dataCad = formatarData(cliente.data_cad);

                // Formatar sexo para exibição
                let sexoFormatado = cliente.sexo;
                switch (cliente.sexo) {
                    case 'M': sexoFormatado = 'Masculino'; break;
                    case 'F': sexoFormatado = 'Feminino'; break;
                    case 'O': sexoFormatado = 'Outro'; break;
                }

                // Construir o HTML do modal
                const modalHTML = `
    <div class="info-section">
        <h4>Dados Pessoais</h4>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">ID:</span>
                <span class="info-value">${escapeHtml(cliente.id_cliente)}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nome:</span>
                <span class="info-value">${escapeHtml(cliente.nome)}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value">${escapeHtml(cliente.email)}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Data de Nascimento:</span>
                <span class="info-value">${dataNasc}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Sexo:</span>
                <span class="info-value">${sexoFormatado}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Data de Cadastro:</span>
                <span class="info-value">${dataCad}</span>
            </div>
            ${cliente.observacao ? `
            <div class="info-item" style="grid-column: 1 / -1;">
                <span class="info-label">Observação:</span>
                <span class="info-value">${escapeHtml(cliente.observacao)}</span>
            </div>
            ` : ''}
        </div>
    </div>
    
    <div class="info-section">
        <h4>Endereço</h4>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">CEP:</span>
                <span class="info-value">${cliente.cep ? escapeHtml(cliente.cep) : 'Não informado'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Logradouro:</span>
                <span class="info-value">${cliente.logradouro ? escapeHtml(cliente.logradouro) : 'Não informado'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Número:</span>
                <span class="info-value">${cliente.numero ? escapeHtml(cliente.numero) : 'Não informado'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Complemento:</span>
                <span class="info-value">${cliente.complemento ? escapeHtml(cliente.complemento) : 'Não informado'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Bairro:</span>
                <span class="info-value">${cliente.bairro ? escapeHtml(cliente.bairro) : 'Não informado'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Cidade:</span>
                <span class="info-value">${cliente.cidade ? escapeHtml(cliente.cidade) : 'Não informado'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">UF:</span>
                <span class="info-value">${cliente.uf ? escapeHtml(cliente.uf) : 'Não informado'}</span>
            </div>
        </div>
    </div>
    
    <div class="info-section">
        <h4>Contato</h4>
        <div class="info-item">
            <span class="info-label">Telefone:</span>
            <span class="info-value">${cliente.telefone ? escapeHtml(cliente.telefone) : 'Não informado'}</span>
        </div>
    </div>
`;

                // Inserir o HTML no modal
                document.getElementById('modalDetalhesBody').innerHTML = modalHTML;
            } else {
                document.getElementById('modalDetalhesBody').innerHTML = '<div class="alert alert-danger">Cliente não encontrado.</div>';
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
            return text.toString().replace(/[&<>"']/g, function (m) { return map[m]; });
        }

        // Fechar modal ao clicar fora do conteúdo
        document.getElementById('modalDetalhes').addEventListener('click', function (e) {
            if (e.target === this) {
                fecharModalDetalhes();
            }
        });

        // Fechar modal com a tecla ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                fecharModalDetalhes();
            }
        });

        // Aplicar máscaras aos campos
        $(document).ready(function () {
            $('#cpf').mask('000.000.000-00');
            $('#cnpj').mask('00.000.000/0000-00');
            $('#telefone, #telefone_jur').mask('(00) 00000-0000');
            $('#cep, #cep_jur').mask('00000-000');
            flatpickr("#dataNascimento", { dateFormat: "d/m/Y" });
            flatpickr("#dataFundacao", { dateFormat: "d/m/Y" });

            // Verificar se há mensagens nos parâmetros da URL
            const urlParams = new URLSearchParams(window.location.search);
            const msgType = urlParams.get('msg');   // 'success' ou 'error'
            const msgText = urlParams.get('text');  // texto da mensagem

            if (msgType && msgText) {
                const notyf = new Notyf({
                    duration: 4000,
                    position: { x: 'right', y: 'top' },
                    types: [
                        {
                            type: 'success',
                            background: '#4caf50',
                            icon: {
                                className: 'material-icons',
                                tagName: 'i',
                                text: 'check'
                            }
                        },
                        {
                            type: 'error',
                            background: '#f44336',
                            icon: {
                                className: 'material-icons',
                                tagName: 'i',
                                text: 'error'
                            }
                        },
                        {
                            type: 'warning',
                            background: '#ff9800',
                            icon: {
                                className: 'material-icons',
                                tagName: 'i',
                                text: 'warning'
                            }
                        }
                    ]
                });

                notyf[msgType](decodeURIComponent(msgText));

                // Remove os parâmetros da URL sem recarregar a página
                const newUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
</body>

</html>