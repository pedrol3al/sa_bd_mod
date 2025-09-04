<?php
session_start();
require '../Conexao/conexao.php';

if($_SESSION['perfil'] !=1){
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit();
}

// Processar inativação do cliente
if(isset($_GET['inativar']) && is_numeric($_GET['inativar'])){
    try {
        $id_cliente = $_GET['inativar'];
        $sql = "UPDATE cliente SET inativo = 1 WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $_SESSION['mensagem'] = 'Cliente inativado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: alterar_cliente.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao inativar o cliente!';
            $_SESSION['tipo_mensagem'] = 'danger';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao inativar cliente: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
    }
}

// Processar ativação do cliente
if(isset($_GET['ativar']) && is_numeric($_GET['ativar'])){
    try {
        $id_cliente = $_GET['ativar'];
        $sql = "UPDATE cliente SET inativo = 0 WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $_SESSION['mensagem'] = 'Cliente ativado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: alterar_cliente.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao ativar o cliente!';
            $_SESSION['tipo_mensagem'] = 'danger';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao ativar cliente: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
    }
}

// Mova todo o código de processamento do POST para DENTRO de uma verificação de método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset(
            $_POST['id_cliente'], $_POST['nome'], $_POST['email'], $_POST['telefone'],
            $_POST['data_nasc'], $_POST['sexo'], $_POST['cep'], $_POST['logradouro'],
            $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['uf'],
            $_POST['observacao']
        )
    ) {
        $id_cliente = $_POST['id_cliente'];
        $nome       = $_POST['nome'];
        $email      = $_POST['email'];
        $telefone   = $_POST['telefone'];
        $data_nasc  = $_POST['data_nasc'];
        $sexo       = $_POST['sexo'];
        $cep        = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $numero     = $_POST['numero'];
        $bairro     = $_POST['bairro'];
        $cidade     = $_POST['cidade'];
        $uf         = $_POST['uf'];
        $observacao = $_POST['observacao'];

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

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':data_nasc', $data_nasc);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':uf', $uf);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Cliente alterado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: alterar_cliente.php?id=' . $id_cliente);
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao alterar o cliente!';
            $_SESSION['tipo_mensagem'] = 'danger';
        }
    } else {
        $_SESSION['mensagem'] = 'Por favor, preencha todos os campos obrigatórios!';
        $_SESSION['tipo_mensagem'] = 'warning';
    }
}

// Se um GET com id for passado, busca os dados do cliente
$clienteAtual = null;
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_cliente = $_GET['id'];
    $sql="SELECT * FROM cliente WHERE id_cliente=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    $clienteAtual = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Se não encontrar o cliente, redireciona
    if(!$clienteAtual) {
        $_SESSION['mensagem'] = 'Cliente não encontrado!';
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: buscar_cliente.php');
        exit;
    }
} else {
    // Se não tem ID, redireciona para busca
    $_SESSION['mensagem'] = 'Nenhum cliente selecionado!';
    $_SESSION['tipo_mensagem'] = 'warning';
    header('Location: buscar_cliente.php');
    exit;
}

// Busca todos os clientes para exibir na tabela (apenas os ativos)
$sql="SELECT * FROM cliente WHERE inativo = 0 ORDER BY nome ASC";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$clientes=$stmt->fetchAll(PDO::FETCH_ASSOC);

// Função auxiliar para evitar erros com valores nulos
function safe_html($value) {
    return $value !== null ? htmlspecialchars($value) : '';
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar cliente</title>
    
    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="alterar.css">
    
</head>
<body>
    <div class="container">
        <h1>ALTERAR CLIENTE #<?= safe_html($clienteAtual['id_cliente'] ?? '') ?></h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <!-- Mensagens de alerta -->
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensagem'] ?> alert-dismissible fade show">
                <?= $_SESSION['mensagem'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php
            unset($_SESSION['mensagem']);
            unset($_SESSION['tipo_mensagem']);
            ?>
        <?php endif; ?>
        
        <div class="mb-3">
            <a href="buscar_cliente.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <?php if($clienteAtual): ?>
        <form method="POST">
            <input type="hidden" name="id_cliente" value="<?= safe_html($clienteAtual['id_cliente'] ?? '') ?>">
            
            <div class="form-section">
                <h2>Dados Pessoais</h2>
                
                <div class="campos_juridica">
                    <div class="linha">
                        <label for="nome_cliente">Nome:</label>
                        <input type="text" id="nome_cliente" name="nome" class="form-control" value="<?= safe_html($clienteAtual['nome'] ?? '') ?>" required>
                    </div>

                    <div class="linha">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= safe_html($clienteAtual['email'] ?? '') ?>" required>
                    </div>

                    <div class="linha">
                        <label for="telefone">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" class="form-control" value="<?= safe_html($clienteAtual['telefone'] ?? '') ?>">
                    </div>

                    <div class="linha">
                        <label for="data_nasc">Data de Nascimento:</label>
                        <input type="text" id="data_nasc" name="data_nasc" class="form-control" value="<?= safe_html($clienteAtual['data_nasc'] ?? '') ?>">
                    </div>

                    <div class="linha">
                        <label for="sexo">Sexo:</label>
                        <select id="sexo" name="sexo" class="form-control">
                            <option value="">Selecione</option>
                            <option value="M" <?= ($clienteAtual['sexo']=='M') ? 'selected' : '' ?>>Masculino</option>
                            <option value="F" <?= ($clienteAtual['sexo']=='F') ? 'selected' : '' ?>>Feminino</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Endereço</h2>
                
                <div class="campos_juridica">
                    <div class="linha">
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep" class="form-control" value="<?= safe_html($clienteAtual['cep'] ?? '') ?>">
                    </div>

                    <div class="linha">
                        <label for="logradouro">Logradouro:</label>
                        <input type="text" id="logradouro" name="logradouro" class="form-control" value="<?= safe_html($clienteAtual['logradouro'] ?? '') ?>">
                    </div>

                    <div class="linha">
                        <label for="numero">Número:</label>
                        <input type="text" id="numero" name="numero" class="form-control" value="<?= safe_html($clienteAtual['numero'] ?? '') ?>">
                    </div>

                    <div class="linha">
                        <label for="bairro">Bairro:</label>
                        <input type="text" id="bairro" name="bairro" class="form-control" value="<?= safe_html($clienteAtual['bairro'] ?? '') ?>">
                    </div>

                    <div class="linha">
                        <label for="cidade">Cidade:</label>
                        <input type="text" id="cidade" name="cidade" class="form-control" value="<?= safe_html($clienteAtual['cidade'] ?? '') ?>">
                    </div>

                    <div class="linha">
                        <label for="uf">UF:</label>
                        <select id="uf" name="uf" class="form-control">
                            <?php
                            $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                            foreach($ufs as $uf){
                                $selected = ($clienteAtual['uf']==$uf) ? 'selected' : '';
                                echo "<option value='$uf' $selected>$uf</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Outras Informações</h2>
                
                <div class="campos_juridica">
                    <div class="linha" style="grid-column: 1 / -1;">
                        <label for="observacao">Observação:</label>
                        <textarea id="observacao" name="observacao" class="form-control" rows="3"><?= safe_html($clienteAtual['observacao'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="container-botoes">
                <button type="reset" class="btn btn-limpar">Limpar</button>
                <button type="submit" class="btn btn-enviar">
                    <i class="bi bi-check-circle"></i> Salvar Alterações
                </button>
                
                <?php if($clienteAtual['inativo'] == 0): ?>
                    <a href="alterar_cliente.php?inativar=<?= $clienteAtual['id_cliente'] ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('Tem certeza que deseja inativar este cliente?')">
                        <i class="bi bi-person-x"></i> Inativar Cliente
                    </a>
                <?php else: ?>
                    <a href="alterar_cliente.php?ativar=<?= $clienteAtual['id_cliente'] ?>" 
                       class="btn btn-success" 
                       onclick="return confirm('Tem certeza que deseja ativar este cliente?')">
                        <i class="bi bi-person-check"></i> Ativar Cliente
                    </a>
                <?php endif; ?>
            </div>
        </form>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <script>
        $(document).ready(function(){
            // Aplicar máscaras aos campos
            $('#cpf').mask('000.000.000-00');
            $('#cnpj').mask('00.000.000/0000-00');
            $('#telefone, #telefone_jur').mask('(00) 00000-0000');
            $('#cep, #cep_jur').mask('00000-000');
            
            // Inicializar datepicker
            flatpickr("#data_nasc", {
                dateFormat: "d/m/Y",
                locale: "pt"
            });
            
            // Buscar endereço pelo CEP
            $('#cep').on('blur', function() {
                var cep = $(this).val().replace(/\D/g, '');
                
                if (cep.length === 8) {
                    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                        if (!data.erro) {
                            $('#logradouro').val(data.logradouro);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.localidade);
                            $('#uf').val(data.uf);
                            $('#numero').focus();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>