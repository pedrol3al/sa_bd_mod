<?php
// Inicia a sessão para poder acessar variáveis de sessão
session_start();
// Inclui o arquivo de conexão com o banco de dados
require '../Conexao/conexao.php';

// Verifica se o usuário tem permissão de administrador (perfil 1)
// Se não tiver, exibe alerta e redireciona para a página principal
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit(); // Encerra a execução do script
}

// Processar inativação do cliente - verifica se o parâmetro 'inativar' foi passado via GET
if (isset($_GET['inativar']) && is_numeric($_GET['inativar'])) {
    try {
        $id_cliente = $_GET['inativar'];
        // Query SQL para atualizar o status do cliente para inativo (inativo = 1)
        $sql = "UPDATE cliente SET inativo = 1 WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($sql); // Prepara a query para execução
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT); // Associa o parâmetro

        if ($stmt->execute()) {
            // Redireciona para a página de busca com mensagem de sucesso
            header("Location: buscar_cliente.php?msg=success&text=Cliente inativado com sucesso!");
            exit; // Encerra a execução do script
        } else {
            // Redireciona para a página de busca com mensagem de erro genérico
            header("Location: buscar_cliente.php?msg=error&text=Erro ao inativar o cliente!");
            exit;
        }
    } catch (PDOException $e) {
        // Em caso de exceção, redireciona com mensagem de erro específica
        header("Location: buscar_cliente.php?msg=error&text=Erro ao inativar cliente: " . urlencode($e->getMessage()));
        exit;
    }
}

// Processar ativação do cliente - verifica se o parâmetro 'ativar' foi passado via GET
if (isset($_GET['ativar']) && is_numeric($_GET['ativar'])) {
    try {
        $id_cliente = $_GET['ativar'];
        // Query SQL para atualizar o status do cliente para ativo (inativo = 0)
        $sql = "UPDATE cliente SET inativo = 0 WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($sql); // Prepara a query para execução
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT); // Associa o parâmetro

        if ($stmt->execute()) {
            // Redireciona para a página de busca com mensagem de sucesso
            header("Location: buscar_cliente.php?msg=success&text=Cliente ativado com sucesso!");
            exit;
        } else {
            // Redireciona para a página de busca com mensagem de erro genérico
            header("Location: buscar_cliente.php?msg=error&text=Erro ao ativar o cliente!");
            exit;
        }
    } catch (PDOException $e) {
        // Em caso de exceção, redireciona com mensagem de erro específica
        header("Location: buscar_cliente.php?msg=error&text=Erro ao ativar cliente: " . urlencode($e->getMessage()));
        exit;
    }
}

// Processamento do formulário quando submetido via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se todos os campos obrigatórios estão presentes no POST
    if (
        isset(
        $_POST['id_cliente'],
        $_POST['nome'],
        $_POST['email'],
        $_POST['telefone'],
        $_POST['data_nasc'],
        $_POST['sexo'],
        $_POST['cep'],
        $_POST['logradouro'],
        $_POST['numero'],
        $_POST['bairro'],
        $_POST['cidade'],
        $_POST['uf'],
        $_POST['observacao']
    )
    ) {
        // Atribui os valores do POST a variáveis locais
        $id_cliente = $_POST['id_cliente'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $data_nasc = $_POST['data_nasc'];
        $sexo = $_POST['sexo'];
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $numero = $_POST['numero'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $observacao = $_POST['observacao'];

        // Query SQL para atualizar os dados do cliente
        $sql = "UPDATE cliente SET 
                    nome = :nome,
                    email = :email,
                    telefone = :telefone,
                    data_nasc = :data_nasc,
                    sexo = :sexo,
                    cep = :cep,
                    logradouro = :logradouro,
                    numero = :numero,
                    bairro = :bairro,
                    cidade = :cidade,
                    uf = :uf,
                    observacao = :observacao
                WHERE id_cliente = :id";

        $stmt = $pdo->prepare($sql); // Prepara a query para execução

        // Associa os parâmetros da query aos valores das variáveis (bind)
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':data_nasc', $data_nasc);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT); // Especifica que é inteiro
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':uf', $uf);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT); // Especifica que é inteiro

        if ($stmt->execute()) {
            // Redireciona para a página de busca com mensagem de sucesso
            header("Location: buscar_cliente.php?msg=success&text=Cliente alterado com sucesso!");
            exit;
        } else {
            // Redireciona para a página de busca com mensagem de erro
            header("Location: buscar_cliente.php?msg=error&text=Erro ao alterar o cliente!");
            exit;
        }
    }
}

// Se um ID foi passado via GET, busca os dados do cliente correspondente
$clienteAtual = null; // Inicializa a variável que armazenará os dados do cliente
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_cliente = $_GET['id'];
    $sql = "SELECT * FROM cliente WHERE id_cliente=:id"; // Query para buscar cliente por ID
    $stmt = $pdo->prepare($sql); // Prepara a query
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT); // Associa o parâmetro ID
    $stmt->execute(); // Executa a query
    $clienteAtual = $stmt->fetch(PDO::FETCH_ASSOC); // Obtém os resultados como array associativo

    // Se não encontrar o cliente, redireciona com mensagem de erro
    if (!$clienteAtual) {
        header("Location: buscar_cliente.php?msg=error&text=Cliente não encontrado!");
        exit;
    }
} else {
    // Se não foi passado um ID, redireciona com mensagem de aviso
    header("Location: buscar_cliente.php?msg=warning&text=Nenhum cliente selecionado!");
    exit;
}

// Busca todos os clientes ativos para exibir na tabela (se necessário)
$sql = "SELECT * FROM cliente WHERE inativo = 0 ORDER BY nome ASC"; // Query para clientes ativos
$stmt = $pdo->prepare($sql); // Prepara a query
$stmt->execute(); // Executa a query
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os resultados

// Função auxiliar para evitar erros com valores nulos e prevenir ataques XSS
function safe_html($value)
{
    // Retorna o valor com caracteres especiais convertidos para entidades HTML
    // ou string vazia se o valor for nulo
    return $value !== null ? htmlspecialchars($value) : '';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura viewport para responsividade -->
    <title>Alterar cliente</title> <!-- Título da página -->

    <!-- Links para frameworks e bibliotecas CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" /> <!-- Ícones Bootstrap -->
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" /> <!-- CSS personalizado para menu lateral -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"> <!-- Notificações CSS -->

    <!-- Favicon (ícone na aba do navegador) -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- CSS personalizado para esta página -->
    <link rel="stylesheet" href="alterar.css">

    <style>
        /* Estilos para as notificações */
        .notyf {
            z-index: 9999; /* Garante que as notificações apareçam acima de outros elementos */
        }

        .notyf__toast {
            max-width: 400px; /* Limita a largura máxima das notificações */
        }
    </style>
</head>

<body>
    <div class="container"> <!-- Container principal do Bootstrap -->
        <h1>ALTERAR CLIENTE #<?= safe_html($clienteAtual['id_cliente'] ?? '') ?></h1> <!-- Título com ID do cliente -->

        <?php include("../Menu_lateral/menu.php"); ?> <!-- Inclui o menu lateral -->

        <div class="mb-3"> <!-- Botão de voltar -->
            <a href="buscar_cliente.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar <!-- Ícone e texto do botão -->
            </a>
        </div>

        <?php if ($clienteAtual): ?> <!-- Verifica se há dados do cliente para exibir -->
            <form method="POST"> <!-- Formulário para edição do cliente -->
                <input type="hidden" name="id_cliente" value="<?= safe_html($clienteAtual['id_cliente'] ?? '') ?>"> <!-- Campo oculto com ID -->

                <div class="form-section"> <!-- Seção de dados pessoais -->
                    <h2>Dados Pessoais</h2>

                    <div class="campos_juridica"> <!-- Container dos campos -->
                        <div class="linha"> <!-- Campo nome -->
                            <label for="nome_cliente">Nome:</label>
                            <input type="text" id="nome_cliente" name="nome" class="form-control"
                                value="<?= safe_html($clienteAtual['nome'] ?? '') ?>" required> <!-- Campo obrigatório -->
                        </div>

                        <div class="linha"> <!-- Campo email -->
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="<?= safe_html($clienteAtual['email'] ?? '') ?>" required> <!-- Campo obrigatório -->
                        </div>

                        <div class="linha"> <!-- Campo telefone -->
                            <label for="telefone">Telefone:</label>
                            <input type="text" id="telefone" name="telefone" class="form-control"
                                value="<?= safe_html($clienteAtual['telefone'] ?? '') ?>">
                        </div>

                        <div class="linha"> <!-- Campo data de nascimento -->
                            <label for="data_nasc">Data de Nascimento:</label>
                            <input type="text" id="data_nasc" name="data_nasc" class="form-control"
                                value="<?= safe_html($clienteAtual['data_nasc'] ?? '') ?>">
                        </div>

                        <div class="linha"> <!-- Campo sexo -->
                            <label for="sexo">Sexo:</label>
                            <select id="sexo" name="sexo" class="form-control">
                                <option value="">Selecione</option>
                                <option value="M" <?= ($clienteAtual['sexo'] == 'M') ? 'selected' : '' ?>>Masculino</option> <!-- Selecionado se for M -->
                                <option value="F" <?= ($clienteAtual['sexo'] == 'F') ? 'selected' : '' ?>>Feminino</option> <!-- Selecionado se for F -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section"> <!-- Seção de endereço -->
                    <h2>Endereço</h2>

                    <div class="campos_juridica"> <!-- Container dos campos de endereço -->
                        <div class="linha"> <!-- Campo CEP -->
                            <label for="cep">CEP:</label>
                            <input type="text" id="cep" name="cep" class="form-control"
                                value="<?= safe_html($clienteAtual['cep'] ?? '') ?>">
                        </div>

                        <div class="linha"> <!-- Campo logradouro -->
                            <label for="logradouro">Logradouro:</label>
                            <input type="text" id="logradouro" name="logradouro" class="form-control"
                                value="<?= safe_html($clienteAtual['logradouro'] ?? '') ?>">
                        </div>

                        <div class="linha"> <!-- Campo número -->
                            <label for="numero">Número:</label>
                            <input type="text" id="numero" name="numero" class="form-control"
                                value="<?= safe_html($clienteAtual['numero'] ?? '') ?>">
                        </div>

                        <div class="linha"> <!-- Campo bairro -->
                            <label for="bairro">Bairro:</label>
                            <input type="text" id="bairro" name="bairro" class="form-control"
                                value="<?= safe_html($clienteAtual['bairro'] ?? '') ?>">
                        </div>

                        <div class="linha"> <!-- Campo cidade -->
                            <label for="cidade">Cidade:</label>
                            <input type="text" id="cidade" name="cidade" class="form-control"
                                value="<?= safe_html($clienteAtual['cidade'] ?? '') ?>">
                        </div>

                        <div class="linha"> <!-- Campo UF (estado) -->
                            <label for="uf">UF:</label>
                            <select id="uf" name="uf" class="form-control">
                                <?php
                                // Array com todas as siglas de estados brasileiros
                                $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
                                // Gera as opções do select
                                foreach ($ufs as $uf) {
                                    // Marca como selecionado o estado atual do cliente
                                    $selected = ($clienteAtual['uf'] == $uf) ? 'selected' : '';
                                    echo "<option value='$uf' $selected>$uf</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section"> <!-- Seção de observações -->
                    <h2>Outras Informações</h2>

                    <div class="campos_juridica">
                        <div class="linha" style="grid-column: 1 / -1;"> <!-- Campo que ocupa toda a largura -->
                            <label for="observacao">Observação:</label>
                            <textarea id="observacao" name="observacao" class="form-control"
                                rows="3"><?= safe_html($clienteAtual['observacao'] ?? '') ?></textarea> <!-- Textarea para observações -->
                        </div>
                    </div>
                </div>

                <div class="container-botoes"> <!-- Container dos botões -->
                    <button type="reset" class="btn btn-limpar">Limpar</button> <!-- Botão para limpar o formulário -->
                    <button type="submit" class="btn btn-enviar"> <!-- Botão para enviar o formulário -->
                        <i class="bi bi-check-circle"></i> Salvar Alterações <!-- Ícone e texto -->
                    </button>

                    <?php if ($clienteAtual['inativo'] == 0): ?> <!-- Se cliente está ativo -->
                        <a href="alterar_cliente.php?inativar=<?= $clienteAtual['id_cliente'] ?>" class="btn btn-danger"
                            onclick="return confirm('Tem certeza que deseja inativar este cliente?')"> <!-- Confirmação JS -->
                            <i class="bi bi-person-x"></i> Inativar Cliente <!-- Ícone e texto -->
                        </a>
                    <?php else: ?> <!-- Se cliente está inativo -->
                        <a href="alterar_cliente.php?ativar=<?= $clienteAtual['id_cliente'] ?>" class="btn btn-success"
                            onclick="return confirm('Tem certeza que deseja ativar este cliente?')"> <!-- Confirmação JS -->
                            <i class="bi bi-person-check"></i> Ativar Cliente <!-- Ícone e texto -->
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <!-- Scripts JavaScript -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script> <!-- Notificações JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> <!-- Máscaras para inputs -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> <!-- Datepicker JS -->
    <script src="cliente.js"></script> <!-- JS personalizado para clientes -->

    <script>
        $(document).ready(function () {
            // Aplicar máscaras aos campos quando o documento estiver pronto
            $('#cpf').mask('000.000.000-00'); // Máscara para CPF
            $('#cnpj').mask('00.000.000/0000-00'); // Máscara para CNPJ
            $('#telefone, #telefone_jur').mask('(00) 00000-0000'); // Máscara para telefone
            $('#cep, #cep_jur').mask('00000-000'); // Máscara para CEP

            // Inicializar datepicker para o campo de data de nascimento
            flatpickr("#data_nasc", {
                dateFormat: "Y/m/d", // Formato da data
                locale: "pt" // Localização em português
            });

            // Buscar endereço automaticamente pelo CEP (usando API ViaCEP)
            $('#cep').on('blur', function () {
                var cep = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos

                if (cep.length === 8) { // Verifica se o CEP tem 8 dígitos
                    // Faz requisição para a API ViaCEP
                    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
                        if (!data.erro) { // Se não houve erro na resposta
                            // Preenche os campos com os dados retornados
                            $('#logradouro').val(data.logradouro);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.localidade);
                            $('#uf').val(data.uf);
                            $('#numero').focus(); // Coloca foco no campo número
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>