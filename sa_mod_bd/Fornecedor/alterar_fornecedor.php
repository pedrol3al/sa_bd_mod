<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    $_SESSION['mensagem'] = 'Acesso Negado!';
    $_SESSION['tipo_mensagem'] = 'error';
    header('Location: buscar_fornecedor.php');
    exit;
}

// Verificar se o ID foi passado
if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = 'ID do fornecedor não especificado!';
    $_SESSION['tipo_mensagem'] = 'error';
    header('Location: buscar_fornecedor.php');
    exit;
}

$id_fornecedor = $_GET['id'];

// Processar exclusão se solicitado
if (isset($_GET['excluir_fornecedor'])) {
    try {
        // Verificar se o fornecedor está vinculado a alguma compra antes de excluir
        $sql_check = "SELECT COUNT(*) as total FROM produto WHERE id_fornecedor = :id_fornecedor";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':id_fornecedor', $id_fornecedor);
        $stmt_check->execute();
        $result = $stmt_check->fetch();
        
        if ($result['total'] > 0) {
            $_SESSION['mensagem'] = 'Não é possível excluir este fornecedor pois existem produtos vinculados a ele!';
            $_SESSION['tipo_mensagem'] = 'error';
            header('Location: buscar_fornecedor.php');
            exit;
        }
        
        // Excluir fornecedor
        $sql = "DELETE FROM fornecedor WHERE id_fornecedor = :id_fornecedor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_fornecedor', $id_fornecedor);
        $stmt->execute();
        
        $_SESSION['mensagem'] = 'Fornecedor excluído com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: buscar_fornecedor.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao excluir fornecedor: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_fornecedor.php');
        exit;
    }
}

// Buscar dados do fornecedor
try {
    $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :id_fornecedor";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_fornecedor', $id_fornecedor);
    $stmt->execute();
    $fornecedor = $stmt->fetch();
    
    if (!$fornecedor) {
        $_SESSION['mensagem'] = 'Fornecedor não encontrado!';
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_fornecedor.php');
        exit;
    }
    
} catch (PDOException $e) {
    $_SESSION['mensagem'] = 'Erro ao carregar fornecedor: ' . $e->getMessage();
    $_SESSION['tipo_mensagem'] = 'error';
    header('Location: buscar_fornecedor.php');
    exit;
}

// Processar atualização
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar_fornecedor'])) {
    try {
        $razao_social = $_POST['razao_social'];
        $email = $_POST['email'];
        $cnpj = $_POST['cnpj'];
        $data_fundacao = !empty($_POST['data_fundacao']) ? $_POST['data_fundacao'] : null;
        $produto_fornecido = $_POST['produto_fornecido'];
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $tipo = $_POST['tipo'];
        $complemento = $_POST['complemento'];
        $numero = $_POST['numero'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $bairro = $_POST['bairro'];
        $telefone = $_POST['telefone'];
        $observacoes = $_POST['observacoes'];
        
        $sql_update = "UPDATE fornecedor 
                       SET razao_social = :razao_social, 
                           email = :email, 
                           cnpj = :cnpj, 
                           data_fundacao = :data_fundacao, 
                           produto_fornecido = :produto_fornecido,
                           cep = :cep,
                           logradouro = :logradouro,
                           tipo = :tipo,
                           complemento = :complemento,
                           numero = :numero,
                           cidade = :cidade,
                           uf = :uf,
                           bairro = :bairro,
                           telefone = :telefone,
                           observacoes = :observacoes
                       WHERE id_fornecedor = :id_fornecedor";
        
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':razao_social', $razao_social);
        $stmt_update->bindParam(':email', $email);
        $stmt_update->bindParam(':cnpj', $cnpj);
        $stmt_update->bindParam(':data_fundacao', $data_fundacao);
        $stmt_update->bindParam(':produto_fornecido', $produto_fornecido);
        $stmt_update->bindParam(':cep', $cep);
        $stmt_update->bindParam(':logradouro', $logradouro);
        $stmt_update->bindParam(':tipo', $tipo);
        $stmt_update->bindParam(':complemento', $complemento);
        $stmt_update->bindParam(':numero', $numero);
        $stmt_update->bindParam(':cidade', $cidade);
        $stmt_update->bindParam(':uf', $uf);
        $stmt_update->bindParam(':bairro', $bairro);
        $stmt_update->bindParam(':telefone', $telefone);
        $stmt_update->bindParam(':observacoes', $observacoes);
        $stmt_update->bindParam(':id_fornecedor', $id_fornecedor);
        
        $stmt_update->execute();
        
        $_SESSION['mensagem'] = 'Fornecedor atualizado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: buscar_fornecedor.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao atualizar fornecedor: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_fornecedor.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Fornecedor</title>
    
    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts de máscara -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    <link rel="stylesheet" href="alterar.css">
    
    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

</head>
<body>
    <?php if (isset($_SESSION['mensagem'])): ?>
        <div class="alert alert-<?= $_SESSION['tipo_mensagem'] == 'error' ? 'danger' : $_SESSION['tipo_mensagem'] ?> alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            <?= $_SESSION['mensagem'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php
        unset($_SESSION['mensagem']);
        unset($_SESSION['tipo_mensagem']);
        ?>
    <?php endif; ?>

    <div class="container">
        <h1>ALTERAR FORNECEDOR #<?= $fornecedor['id_fornecedor'] ?></h1>
        
        <?php include("../Menu_lateral/menu.php"); ?>
        
        <form method="POST" action="">
            <input type="hidden" name="atualizar_fornecedor" value="1">
            
            <div class="form-section">
                <h2>Dados do Fornecedor</h2>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="razao_social" class="form-label">Razão Social:</label>
                            <input type="text" id="razao_social" name="razao_social" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['razao_social']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['email']) ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cnpj" class="form-label">CNPJ:</label>
                            <input type="text" id="cnpj" name="cnpj" class="form-control cnpj-mask" 
                                   value="<?= htmlspecialchars($fornecedor['cnpj']) ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_fundacao" class="form-label">Data de Fundação:</label>
                            <input type="date" id="data_fundacao" name="data_fundacao" class="form-control" 
                                   value="<?= $fornecedor['data_fundacao'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="produto_fornecido" class="form-label">Produto Fornecido:</label>
                            <input type="text" id="produto_fornecido" name="produto_fornecido" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['produto_fornecido']) ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Endereço</h2>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cep" class="form-label">CEP:</label>
                            <input type="text" id="cep" name="cep" class="form-control cep-mask" 
                                   value="<?= htmlspecialchars($fornecedor['cep']) ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logradouro" class="form-label">Logradouro:</label>
                            <input type="text" id="logradouro" name="logradouro" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['logradouro']) ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo" class="form-label">Tipo:</label>
                            <input type="text" id="tipo" name="tipo" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['tipo']) ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="numero" class="form-label">Número:</label>
                            <input type="number" id="numero" name="numero" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['numero']) ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="complemento" class="form-label">Complemento:</label>
                            <input type="text" id="complemento" name="complemento" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['complemento']) ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bairro" class="form-label">Bairro:</label>
                            <input type="text" id="bairro" name="bairro" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['bairro']) ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cidade" class="form-label">Cidade:</label>
                            <input type="text" id="cidade" name="cidade" class="form-control" 
                                   value="<?= htmlspecialchars($fornecedor['cidade']) ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="uf" class="form-label">UF:</label>
                            <select id="uf" name="uf" class="form-control">
                                <option value="">Selecione</option>
                                <option value="AC" <?= $fornecedor['uf'] == 'AC' ? 'selected' : '' ?>>AC</option>
                                <option value="AL" <?= $fornecedor['uf'] == 'AL' ? 'selected' : '' ?>>AL</option>
                                <option value="AM" <?= $fornecedor['uf'] == 'AM' ? 'selected' : '' ?>>AM</option>
                                <option value="AP" <?= $fornecedor['uf'] == 'AP' ? 'selected' : '' ?>>AP</option>
                                <option value="BA" <?= $fornecedor['uf'] == 'BA' ? 'selected' : '' ?>>BA</option>
                                <option value="CE" <?= $fornecedor['uf'] == 'CE' ? 'selected' : '' ?>>CE</option>
                                <option value="DF" <?= $fornecedor['uf'] == 'DF' ? 'selected' : '' ?>>DF</option>
                                <option value="ES" <?= $fornecedor['uf'] == 'ES' ? 'selected' : '' ?>>ES</option>
                                <option value="GO" <?= $fornecedor['uf'] == 'GO' ? 'selected' : '' ?>>GO</option>
                                <option value="MA" <?= $fornecedor['uf'] == 'MA' ? 'selected' : '' ?>>MA</option>
                                <option value="MG" <?= $fornecedor['uf'] == 'MG' ? 'selected' : '' ?>>MG</option>
                                <option value="MS" <?= $fornecedor['uf'] == 'MS' ? 'selected' : '' ?>>MS</option>
                                <option value="MT" <?= $fornecedor['uf'] == 'MT' ? 'selected' : '' ?>>MT</option>
                                <option value="PA" <?= $fornecedor['uf'] == 'PA' ? 'selected' : '' ?>>PA</option>
                                <option value="PB" <?= $fornecedor['uf'] == 'PB' ? 'selected' : '' ?>>PB</option>
                                <option value="PE" <?= $fornecedor['uf'] == 'PE' ? 'selected' : '' ?>>PE</option>
                                <option value="PI" <?= $fornecedor['uf'] == 'PI' ? 'selected' : '' ?>>PI</option>
                                <option value="PR" <?= $fornecedor['uf'] == 'PR' ? 'selected' : '' ?>>PR</option>
                                <option value="RJ" <?= $fornecedor['uf'] == 'RJ' ? 'selected' : '' ?>>RJ</option>
                                <option value="RN" <?= $fornecedor['uf'] == 'RN' ? 'selected' : '' ?>>RN</option>
                                <option value="RO" <?= $fornecedor['uf'] == 'RO' ? 'selected' : '' ?>>RO</option>
                                <option value="RR" <?= $fornecedor['uf'] == 'RR' ? 'selected' : '' ?>>RR</option>
                                <option value="RS" <?= $fornecedor['uf'] == 'RS' ? 'selected' : '' ?>>RS</option>
                                <option value="SC" <?= $fornecedor['uf'] == 'SC' ? 'selected' : '' ?>>SC</option>
                                <option value="SE" <?= $fornecedor['uf'] == 'SE' ? 'selected' : '' ?>>SE</option>
                                <option value="SP" <?= $fornecedor['uf'] == 'SP' ? 'selected' : '' ?>>SP</option>
                                <option value="TO" <?= $fornecedor['uf'] == 'TO' ? 'selected' : '' ?>>TO</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="telefone" class="form-label">Telefone:</label>
                            <input type="text" id="telefone" name="telefone" class="form-control phone-mask" 
                                   value="<?= htmlspecialchars($fornecedor['telefone']) ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Outras Informações</h2>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="observacoes" class="form-label">Observações:</label>
                            <textarea id="observacoes" name="observacoes" class="form-control" rows="3"><?= htmlspecialchars($fornecedor['observacoes']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="actions">
                <a href="buscar_fornecedor.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    <i class="bi bi-trash"></i> Excluir Fornecedor
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
                    <p>Tem certeza que deseja excluir este Fornecedor?</p>
                    <p class="text-danger"><strong>Esta ação não pode ser desfeita!</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="alterar_fornecedor.php?id=<?= $id_fornecedor ?>&excluir_fornecedor=1" class="btn btn-danger">Excluir Permanentemente</a>
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

            // Aplicar máscaras aos campos
            $('.cnpj-mask').mask('00.000.000/0000-00');
            $('.cep-mask').mask('00000-000');
            $('.phone-mask').mask('(00) 00000-0000');
            
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