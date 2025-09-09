<?php
// Inicia a sessão para poder acessar variáveis de sessão
session_start();
// Inclui o arquivo de conexão com o banco de dados (usando require_once para incluir apenas uma vez)
require_once '../Conexao/conexao.php';

// Verifica se o usuário tem permissão de administrador (perfil 1) ou atendente (perfil 2)
// Se não tiver, exibe alerta e redireciona para a página principal
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit(); // Encerra a execução do script
}

$clientes = []; // Inicializa a variável que armazenará os clientes

// Verifica se o formulário de busca foi submetido via método POST e se o campo de busca não está vazio
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca_cliente'])) {
    $busca = trim($_POST['busca_cliente']); // Remove espaços em branco do início e fim da busca

    // Verifica se a busca é numérica (provavelmente um ID)
    if (is_numeric($busca)) {
        // Query para buscar cliente por ID
        $sql = "SELECT * FROM cliente WHERE id_cliente = :busca ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql); // Prepara a query
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT); // Associa o parâmetro como inteiro
    } else {
        // Query para buscar cliente por nome (usando LIKE para busca parcial)
        $sql = "SELECT * FROM cliente WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql); // Prepara a query
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR); // Busca nomes que começam com o termo
    }
} else {
    // Se não houve busca, lista todos os clientes ordenados por nome
    $sql = "SELECT * FROM cliente ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql); // Prepara a query
}

$stmt->execute(); // Executa a query
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os resultados como array associativo

// Se um ID foi passado via GET, busca os dados do cliente correspondente para edição
$clienteAtual = null; // Inicializa a variável
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_cliente = $_GET['id'];
    $sql = "SELECT * FROM cliente WHERE id_cliente = :id"; // Query para buscar cliente por ID
    $stmt = $pdo->prepare($sql); // Prepara a query
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT); // Associa o parâmetro ID
    $stmt->execute(); // Executa a query
    $clienteAtual = $stmt->fetch(PDO::FETCH_ASSOC); // Obtém o resultado
}

// Processamento da atualização do cliente (se os campos necessários foram enviados)
if (isset($_POST['id_cliente'], $_POST['nome'], $_POST['email'])) {
    $id_cliente = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Query para atualizar nome e email do cliente
    $sql = "UPDATE cliente SET nome = :nome, email = :email WHERE id_cliente = :id";
    $stmt = $pdo->prepare($sql); // Prepara a query
    $stmt->bindParam(':nome', $nome); // Associa o parâmetro nome
    $stmt->bindParam(':email', $email); // Associa o parâmetro email
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT); // Associa o parâmetro ID como inteiro

    if ($stmt->execute()) {
        // Se a atualização foi bem-sucedida, exibe alerta e redireciona
        echo "<script>alert('Cliente alterado com sucesso!');window.location.href='alterar_cliente.php';</script>";
        exit; // Encerra a execução do script
    } else {
        // Se houve erro na atualização, exibe alerta de erro
        echo "<script>alert('Erro ao alterar o cliente!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura viewport para responsividade -->
    <title>Buscar cliente</title> <!-- Título da página -->

    <!-- Links para frameworks e bibliotecas CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" /> <!-- Ícones Bootstrap -->
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" /> <!-- CSS personalizado para menu lateral -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"> <!-- Notificações CSS -->

    <!-- Favicon (ícone na aba do navegador) -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- CSS personalizado para esta página -->
    <link rel="stylesheet" href="buscar.css">
</head>

<body>
    <div class="container"> <!-- Container principal do Bootstrap -->
        <h1>BUSCAR CLIENTES</h1> <!-- Título principal da página -->

        <?php include("../Menu_lateral/menu.php"); ?> <!-- Inclui o menu lateral -->

        <!-- Seção de busca -->
        <div class="search-section">
            <form method="POST" action=""> <!-- Formulário de busca com método POST -->
                <div class="form-group">
                    <label for="busca_cliente" class="form-label fw-bold">Digite o ID ou Nome do cliente:</label>
                    <div class="search-container">
                        <!-- Campo de input para busca -->
                        <input type="text" id="busca_cliente" name="busca_cliente" class="form-control search-input"
                            placeholder="Ex: 12 ou João"
                            value="<?= isset($_POST['busca_cliente']) ? htmlspecialchars($_POST['busca_cliente']) : '' ?>"
                            required> <!-- Campo obrigatório -->
                        <button class="btn btn-primary px-4" type="submit"> <!-- Botão de submit -->
                            <i class="bi bi-search"></i> Buscar <!-- Ícone e texto do botão -->
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabela de resultados -->
        <div class="card"> <!-- Card Bootstrap para organizar a tabela -->
            <div class="card-header"> <!-- Cabeçalho do card -->
                <i class="bi bi-people-fill"></i> Clientes Encontrados <!-- Ícone e texto -->
            </div>
            <div class="card-body"> <!-- Corpo do card -->
                <?php if (!empty($clientes)): ?> <!-- Verifica se há clientes para exibir -->
                    <div class="table-responsive"> <!-- Torna a tabela responsiva -->
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0"> <!-- Tabela Bootstrap -->
                            <thead> <!-- Cabeçalho da tabela -->
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Observação</th>
                                    <th>Data de Nascimento</th>
                                    <th>Sexo</th>
                                    <th>Ações</th> <!-- Coluna para botões de ação -->
                                </tr>
                            </thead>
                            <tbody> <!-- Corpo da tabela -->
                                <?php foreach ($clientes as $cliente): ?> <!-- Loop através de cada cliente -->
                                    <tr> <!-- Linha da tabela -->
                                        <td><?= htmlspecialchars($cliente['id_cliente']) ?></td> <!-- ID do cliente -->
                                        <td><?= htmlspecialchars($cliente['nome']) ?></td> <!-- Nome do cliente -->
                                        <td><?= htmlspecialchars($cliente['email']) ?></td> <!-- Email do cliente -->
                                        <td><?= !empty($cliente['observacao']) ? htmlspecialchars($cliente['observacao']) : 'Nenhuma' ?>
                                        </td> <!-- Observação ou "Nenhuma" se vazia -->
                                        <td><?= htmlspecialchars($cliente['data_nasc']) ?></td> <!-- Data de nascimento -->
                                        <td> <!-- Sexo formatado -->
                                            <?php
                                            // Converte a sigla do sexo para texto completo
                                            switch ($cliente['sexo']) {
                                                case 'M':
                                                    echo 'Masculino';
                                                    break;
                                                case 'F':
                                                    echo 'Feminino';
                                                    break;
                    
                                                default:
                                                    echo htmlspecialchars($cliente['sexo']); // Exibe o valor original se não for M/F/O
                                            }
                                            ?>
                                        </td>
                                        <td class="actions"> <!-- Célula de ações -->
                                            <!-- Botão para alterar cliente -->
                                            <a class="btn btn-warning btn-sm"
                                                href="alterar_cliente.php?id=<?= htmlspecialchars($cliente['id_cliente']) ?>">
                                                <i class="bi bi-pencil"></i> Alterar <!-- Ícone e texto -->
                                            </a>
                                            <!-- Botão para ver detalhes do cliente (abre modal) -->
                                            <button class="btn btn-info btn-sm btn-detalhes"
                                                onclick="abrirModalDetalhes(<?= $cliente['id_cliente'] ?>)">
                                                <i class="bi bi-info-circle"></i> Detalhes <!-- Ícone e texto -->
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?> <!-- Fim do loop -->
                            </tbody>
                        </table>
                    </div>
                <?php else: ?> <!-- Se não há clientes -->
                    <div class="no-results"> <!-- Container para mensagem de nenhum resultado -->
                        <i class="bi bi-search" style="font-size: 3rem;"></i> <!-- Ícone de busca -->
                        <h4>Nenhum cliente encontrado</h4> <!-- Título -->
                        <p><?= isset($_POST['busca_cliente']) ? 'Tente ajustar os termos da busca.' : 'Não há clientes cadastrados.' ?>
                        </p> <!-- Mensagem contextual -->
                    </div>
                <?php endif; ?> <!-- Fim da verificação -->
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes do Cliente (inicialmente oculto) -->
    <div class="modal-overlay" id="modalDetalhes">
        <div class="modal-content">
            <div class="modal-header"> <!-- Cabeçalho do modal -->
                <h3>Informações Detalhadas do Cliente</h3> <!-- Título do modal -->
                <button class="modal-close" onclick="fecharModalDetalhes()">&times;</button> <!-- Botão de fechar -->
            </div>
            <div class="modal-body" id="modalDetalhesBody"> <!-- Corpo do modal -->
                <!-- Conteúdo será carregado via JavaScript -->
                <div class="text-center p-4">Carregando informações do cliente...</div> <!-- Placeholder -->
            </div>
        </div>
    </div>

    <!-- Scripts JavaScript -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script> <!-- Notificações JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> <!-- Máscaras para inputs -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> <!-- Datepicker JS -->

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

        // Função para escapar HTML (prevenir XSS - Cross-Site Scripting)
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

        // Aplicar máscaras aos campos quando o documento estiver pronto
        $(document).ready(function () {
            $('#cpf').mask('000.000.000-00'); // Máscara para CPF
            $('#cnpj').mask('00.000.000/0000-00'); // Máscara para CNPJ
            $('#telefone, #telefone_jur').mask('(00) 00000-0000'); // Máscara para telefone
            $('#cep, #cep_jur').mask('00000-000'); // Máscara para CEP
            flatpickr("#dataNascimento", { dateFormat: "d/m/Y" }); // Datepicker para data de nascimento
            flatpickr("#dataFundacao", { dateFormat: "d/m/Y" }); // Datepicker para data de fundação

            // Verificar se há mensagens nos parâmetros da URL
            const urlParams = new URLSearchParams(window.location.search);
            const msgType = urlParams.get('msg');   // 'success' ou 'error'
            const msgText = urlParams.get('text');  // texto da mensagem

            if (msgType && msgText) {
                const notyf = new Notyf({
                    duration: 4000, // Duração da notificação em milissegundos
                    position: { x: 'right', y: 'top' }, // Posição da notificação
                    types: [ // Tipos de notificação
                        {
                            type: 'success', // Tipo sucesso
                            background: '#4caf50', // Cor de fundo verde
                            icon: { // Ícone de sucesso
                                className: 'material-icons',
                                tagName: 'i',
                                text: 'check'
                            }
                        },
                        {
                            type: 'error', // Tipo erro
                            background: '#f44336', // Cor de fundo vermelho
                            icon: { // Ícone de erro
                                className: 'material-icons',
                                tagName: 'i',
                                text: 'error'
                            }
                        },
                        {
                            type: 'warning', // Tipo aviso
                            background: '#ff9800', // Cor de fundo laranja
                            icon: { // Ícone de aviso
                                className: 'material-icons',
                                tagName: 'i',
                                text: 'warning'
                            }
                        }
                    ]
                });

                notyf[msgType](decodeURIComponent(msgText)); // Exibe a notificação

                // Remove os parâmetros da URL sem recarregar a página
                const newUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
</body>

</html>