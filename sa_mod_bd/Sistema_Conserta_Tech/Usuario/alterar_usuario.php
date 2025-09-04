<?php
session_start();
require '../Conexao/conexao.php';

// Verifica se é admin
if($_SESSION['perfil'] !=1){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

// Processar inativação do usuário
if(isset($_GET['inativar']) && is_numeric($_GET['inativar'])){
    try {
        $id_usuario = $_GET['inativar'];
        $sql = "UPDATE usuario SET inativo = 1 WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $_SESSION['mensagem'] = 'Usuário inativado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: alterar_usuario.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao inativar o usuário!';
            $_SESSION['tipo_mensagem'] = 'danger';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao inativar usuário: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
    }
}

// Processar ativação do usuário
if(isset($_GET['ativar']) && is_numeric($_GET['ativar'])){
    try {
        $id_usuario = $_GET['ativar'];
        $sql = "UPDATE usuario SET inativo = 0 WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $_SESSION['mensagem'] = 'Usuário ativado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: alterar_usuario.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao ativar o usuário!';
            $_SESSION['tipo_mensagem'] = 'danger';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao ativar usuário: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
    }
}

// Se um POST for enviado, atualiza o usuario
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_usuario'])){
    try {
        $id_usuario = $_POST['id_usuario'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $id_perfil = $_POST['perfil'];
        $cpf = $_POST['cpf'];
        $username = $_POST['username'];
        $data_nasc = $_POST['data_nasc'];
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $numero = $_POST['numero'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $bairro = $_POST['bairro'];
        $telefone = $_POST['telefone'];

        $sql = "UPDATE usuario SET 
                    nome = :nome, 
                    email = :email, 
                    id_perfil = :id_perfil, 
                    cpf = :cpf, 
                    username = :username, 
                    data_nasc = :data_nasc, 
                    cep = :cep, 
                    logradouro = :logradouro, 
                    numero = :numero, 
                    cidade = :cidade, 
                    uf = :estado, 
                    bairro = :bairro, 
                    telefone = :telefone 
                WHERE id_usuario = :id_usuario";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':data_nasc', $data_nasc);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        if($stmt->execute()){
            $_SESSION['mensagem'] = 'Usuário alterado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: alterar_usuario.php?id=' . $id_usuario);
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao alterar o usuário!';
            $_SESSION['tipo_mensagem'] = 'danger';
        }
        
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao alterar usuário: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
    }
}

// Se um GET com id for passado, busca os dados do usuario
$usuarioAtual = null;
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];
    $sql = "SELECT * FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    $usuarioAtual = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Busca todos os usuarios para exibir na tabela (apenas os ativos)
$sql = "SELECT * FROM usuario WHERE inativo = 0 ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Alterar usuario</title>
    
    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --background-color: #ecf0f1;
            --text-color: #2c3e50;
            --border-color: #bdc3c7;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
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
        
        h1, h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            text-align: center;
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
        
        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }
        
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }
        
        .form-section {
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            padding: 15px;
            border-radius: 5px;
            background-color: white;
        }
        
        .form-section h2 {
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .form-group input, 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-group input:focus, 
        .form-group select:focus, 
        .form-group textarea:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            margin-right: 10px;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-ativo {
            background-color: var(--success-color);
            color: white;
        }
        
        .status-inativo {
            background-color: var(--danger-color);
            color: white;
        }
        
        /* Ajuste para telas menores */
        @media (max-width: 992px) {
            .container {
                margin-left: 20px;
                margin-right: 20px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .table-responsive {
                overflow-x: auto;
            }
        }
        
        /* Badge para perfil */
        .perfil-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .perfil-1 { background-color: #e74c3c; color: white; }
        .perfil-2 { background-color: #3498db; color: white; }
        .perfil-3 { background-color: #2ecc71; color: white; }
        .perfil-4 { background-color: #f39c12; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ALTERAR USUÁRIOS</h1>
        
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
            <a href="buscar_usuario.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <!-- Tabela de usuários -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-people-fill"></i> Lista de Usuários Ativos
            </div>
            <div class="card-body">
                <?php if(!empty($usuarios)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Perfil</th>
                                    <th>Nome</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($usuarios as $usuario): 
                                    $perfil_text = '';
                                    $perfil_class = '';
                                    switch($usuario['id_perfil']) {
                                        case 1: $perfil_text = 'Admin'; $perfil_class = 'perfil-1'; break;
                                        case 2: $perfil_text = 'Atendente'; $perfil_class = 'perfil-2'; break;
                                        case 3: $perfil_text = 'Técnico'; $perfil_class = 'perfil-3'; break;
                                        case 4: $perfil_text = 'Financeiro'; $perfil_class = 'perfil-4'; break;
                                        default: $perfil_text = $usuario['id_perfil']; $perfil_class = '';
                                    }
                                    
                                    $status_text = $usuario['inativo'] ? 'Inativo' : 'Ativo';
                                    $status_class = $usuario['inativo'] ? 'status-inativo' : 'status-ativo';
                                ?>
                                <tr>
                                    <td><?= safe_html($usuario['id_usuario']) ?></td>
                                    <td><span class="perfil-badge <?= $perfil_class ?>"><?= $perfil_text ?></span></td>
                                    <td><?= safe_html($usuario['nome']) ?></td>
                                    <td><?= safe_html($usuario['username']) ?></td>
                                    <td><?= safe_html($usuario['email']) ?></td>
                                    <td><span class="status-badge <?= $status_class ?>"><?= $status_text ?></span></td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href="alterar_usuario.php?id=<?= safe_html($usuario['id_usuario']) ?>">
                                            <i class="bi bi-pencil"></i> Alterar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Nenhum usuário ativo encontrado!
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Formulário de edição -->
        <?php if($usuarioAtual): ?>
        <div class="form-section">
            <h2>Editar Usuário: <?= safe_html($usuarioAtual['nome']) ?></h2>
            
            <form method="POST">
                <input type="hidden" name="id_usuario" value="<?= safe_html($usuarioAtual['id_usuario']) ?>">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="perfil">Perfil:</label>
                        <select id="perfil" name="perfil" class="form-control" required>
                            <option value="1" <?= $usuarioAtual['id_perfil'] == 1 ? 'selected' : '' ?>>Administrador</option>
                            <option value="2" <?= $usuarioAtual['id_perfil'] == 2 ? 'selected' : '' ?>>Atendente</option>
                            <option value="3" <?= $usuarioAtual['id_perfil'] == 3 ? 'selected' : '' ?>>Técnico</option>
                            <option value="4" <?= $usuarioAtual['id_perfil'] == 4 ? 'selected' : '' ?>>Financeiro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control" 
                               value="<?= safe_html($usuarioAtual['nome']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" class="form-control" 
                               value="<?= safe_html($usuarioAtual['cpf']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" 
                               value="<?= safe_html($usuarioAtual['username']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="<?= safe_html($usuarioAtual['email']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="data_nasc">Data de Nascimento:</label>
                        <input type="date" id="data_nasc" name="data_nasc" class="form-control" 
                               value="<?= safe_html($usuarioAtual['data_nasc']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep" class="form-control" 
                               value="<?= safe_html($usuarioAtual['cep']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="logradouro">Logradouro:</label>
                        <input type="text" id="logradouro" name="logradouro" class="form-control" 
                               value="<?= safe_html($usuarioAtual['logradouro']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="numero">Número:</label>
                        <input type="text" id="numero" name="numero" class="form-control" 
                               value="<?= safe_html($usuarioAtual['numero']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="cidade">Cidade:</label>
                        <input type="text" id="cidade" name="cidade" class="form-control" 
                               value="<?= safe_html($usuarioAtual['cidade']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select id="estado" name="estado" class="form-control">
                            <option value="">Selecione</option>
                            <?php
                            $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                            foreach($ufs as $uf){
                                $selected = ($usuarioAtual['uf'] == $uf) ? 'selected' : '';
                                echo "<option value='$uf' $selected>$uf</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bairro">Bairro:</label>
                        <input type="text" id="bairro" name="bairro" class="form-control" 
                               value="<?= safe_html($usuarioAtual['bairro']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" class="form-control" 
                               value="<?= safe_html($usuarioAtual['telefone']) ?>">
                    </div>
                </div>

                <div class="actions">
                    <button type="reset" class="btn btn-secondary">Limpar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Salvar Alterações
                    </button>
                    
                    <?php if($usuarioAtual['inativo'] == 0): ?>
                        <a href="alterar_usuario.php?inativar=<?= $usuarioAtual['id_usuario'] ?>" 
                           class="btn btn-danger" 
                           onclick="return confirm('Tem certeza que deseja inativar este usuário?')">
                            <i class="bi bi-person-x"></i> Inativar Usuário
                        </a>
                    <?php else: ?>
                        <a href="alterar_usuario.php?ativar=<?= $usuarioAtual['id_usuario'] ?>" 
                           class="btn btn-success" 
                           onclick="return confirm('Tem certeza que deseja ativar este usuário?')">
                            <i class="bi bi-person-check"></i> Ativar Usuário
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
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
            $('#telefone').mask('(00) 00000-0000');
            $('#cep').mask('00000-000');
            
            // Buscar endereço pelo CEP
            $('#cep').on('blur', function() {
                var cep = $(this).val().replace(/\D/g, '');
                
                if (cep.length === 8) {
                    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                        if (!data.erro) {
                            $('#logradouro').val(data.logradouro);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.localidade);
                            $('#estado').val(data.uf);
                            $('#numero').focus();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>