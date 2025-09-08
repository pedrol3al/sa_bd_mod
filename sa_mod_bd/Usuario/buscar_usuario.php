<?php
session_start();
require_once '../Conexao/conexao.php';

// Verifica permissão de administrador ou secretaria 
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit();
}

// Processar inativação do usuário
if (isset($_GET['inativar']) && is_numeric($_GET['inativar'])) {
    try {
        $id_usuario = $_GET['inativar'];
        $sql = "UPDATE usuario SET inativo = 1 WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Usuário inativado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: buscar_usuario.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao inativar o usuário!';
            $_SESSION['tipo_mensagem'] = 'error';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao inativar usuário: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
    }
}

// Processar ativação do usuário
if (isset($_GET['ativar']) && is_numeric($_GET['ativar'])) {
    try {
        $id_usuario = $_GET['ativar'];
        $sql = "UPDATE usuario SET inativo = 0 WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Usuário ativado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: buscar_usuario.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao ativar o usuário!';
            $_SESSION['tipo_mensagem'] = 'error';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao ativar usuário: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
    }
}

$usuarios = []; // Inicializa a variável

// Se o formulário for enviado, busca pelo ID ou nome
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca_usuario'])) {
    $busca = trim($_POST['busca_usuario']);

    if (is_numeric($busca)) {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
    }
} else {
    $sql = "SELECT * FROM usuario ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuário</title>

    <!-- Links bootstrap e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <link rel="stylesheet" href="buscar.css">

</head>

<body>
    <div class="container">
        <h1>BUSCAR USUÁRIOS</h1>

        <?php include("../Menu_lateral/menu.php"); ?>

        <!-- Seção de busca -->
        <div class="search-section">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="busca_usuario" class="form-label fw-bold">Digite o ID ou Nome do Usuário:</label>
                    <div class="search-container">
                        <input type="text" id="busca_usuario" name="busca_usuario" class="form-control search-input"
                            placeholder="Ex: 12 ou João"
                            value="<?= isset($_POST['busca_usuario']) ? htmlspecialchars($_POST['busca_usuario']) : '' ?>"
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
                <i class="bi bi-people-fill"></i> Usuários Encontrados
            </div>
            <div class="card-body">
                <?php if (!empty($usuarios)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Perfil</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Data de Cadastro</th>
                                    <th>Data de Nascimento</th>
                                    <th>Sexo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario):
                                    $perfil_text = '';
                                    $perfil_class = '';
                                    switch ($usuario['id_perfil']) {
                                        case 1:
                                            $perfil_text = 'Admin';
                                            $perfil_class = 'perfil-1';
                                            break;
                                        case 2:
                                            $perfil_text = 'Atendente';
                                            $perfil_class = 'perfil-2';
                                            break;
                                        case 3:
                                            $perfil_text = 'Técnico';
                                            $perfil_class = 'perfil-3';
                                            break;
                                        case 4:
                                            $perfil_text = 'Financeiro';
                                            $perfil_class = 'perfil-4';
                                            break;
                                        case 5:
                                            $perfil_text = 'Almoxarife';
                                            $perfil_class = 'perfil-5';
                                            break;
                                        default:
                                            $perfil_text = $usuario['id_perfil'];
                                            $perfil_class = '';
                                    }

                                    $sexo_text = '';
                                    switch ($usuario['sexo']) {
                                        case 'M':
                                            $sexo_text = 'Masculino';
                                            break;
                                        case 'F':
                                            $sexo_text = 'Feminino';
                                            break;
                                        case 'O':
                                            $sexo_text = 'Outro';
                                            break;
                                        default:
                                            $sexo_text = $usuario['sexo'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                                        <td><span class="perfil-badge <?= $perfil_class ?>"><?= $perfil_text ?></span></td>
                                        <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                        <td><?= htmlspecialchars($usuario['cpf']) ?></td>
                                        <td><?= htmlspecialchars($usuario['username']) ?></td>
                                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                                        <td><?= htmlspecialchars($usuario['data_cad']) ?></td>
                                        <td><?= htmlspecialchars($usuario['data_nasc']) ?></td>
                                        <td><?= $sexo_text ?></td>
                                        <td class="actions">
                                            <a class="btn btn-warning btn-sm"
                                                href="alterar_usuario.php?id=<?= htmlspecialchars($usuario['id_usuario']) ?>">
                                                <i class="bi bi-pencil"></i> Alterar
                                            </a>
                                            <!-- Botão de Informações Detalhadas -->
                                            <button class="btn btn-info btn-sm btn-detalhes"
                                                onclick="abrirModalDetalhes(<?= $usuario['id_usuario'] ?>)">
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
                        <h4>Nenhum usuário encontrado</h4>
                        <p><?= isset($_POST['busca_usuario']) ? 'Tente ajustar os termos da busca.' : 'Não há usuários cadastrados.' ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes do Usuário -->
    <div class="modal-overlay" id="modalDetalhes">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Informações Detalhadas do Usuário</h3>
                <button class="modal-close" onclick="fecharModalDetalhes()">&times;</button>
            </div>
            <div class="modal-body" id="modalDetalhesBody">
                <!-- Conteúdo será carregado via JavaScript -->
                <div class="text-center p-4">Carregando informações do usuário...</div>
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
        // Dados dos usuários em formato JSON para uso no modal
        const usuariosData = <?php echo json_encode($usuarios); ?>;

        // Funções para controlar o modal de detalhes
        function abrirModalDetalhes(idUsuario) {
            // Encontrar o usuário com o ID correspondente
            const usuario = usuariosData.find(u => u.id_usuario == idUsuario);

            if (usuario) {
                // Formatar as datas para exibição
                const dataNasc = formatarData(usuario.data_nasc);
                const dataCad = formatarData(usuario.data_cad);

                // Formatar perfil para exibição
                let perfilFormatado = '';
                switch (usuario.id_perfil) {
                    case 1: perfilFormatado = 'Administrador'; break;
                    case 2: perfilFormatado = 'Atendente'; break;
                    case 3: perfilFormatado = 'Técnico'; break;
                    case 4: perfilFormatado = 'Financeiro'; break;
                    default: perfilFormatado = usuario.id_perfil;
                }

                // Formatar sexo para exibição
                let sexoFormatado = usuario.sexo;
                switch (usuario.sexo) {
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
                                <span class="info-value">${escapeHtml(usuario.id_usuario)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Nome:</span>
                                <span class="info-value">${escapeHtml(usuario.nome)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Username:</span>
                                <span class="info-value">${escapeHtml(usuario.username)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">${escapeHtml(usuario.email)}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">CPF:</span>
                                <span class="info-value">${usuario.cpf ? escapeHtml(usuario.cpf) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Perfil:</span>
                                <span class="info-value">${perfilFormatado}</span>
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
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4>Endereço</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">CEP:</span>
                                <span class="info-value">${usuario.cep ? escapeHtml(usuario.cep) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Logradouro:</span>
                                <span class="info-value">${usuario.logradouro ? escapeHtml(usuario.logradouro) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Número:</span>
                                <span class="info-value">${usuario.numero ? escapeHtml(usuario.numero) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label>Complemento:</span>
                                <span class="info-value">${usuario.complemento ? escapeHtml(usuario.complemento) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Bairro:</span>
                                <span class="info-value">${usuario.bairro ? escapeHtml(usuario.bairro) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Cidade:</span>
                                <span class="info-value">${usuario.cidade ? escapeHtml(usuario.cidade) : 'Não informado'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">UF:</span>
                                <span class="info-value">${usuario.uf ? escapeHtml(usuario.uf) : 'Não informado'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4>Contato</h4>
                        <div class="info-item">
                            <span class="info-label">Telefone:</span>
                            <span class="info-value">${usuario.telefone ? escapeHtml(usuario.telefone) : 'Não informado'}</span>
                        </div>
                    </div>
                `;

                // Inserir o HTML no modal
                document.getElementById('modalDetalhesBody').innerHTML = modalHTML;
            } else {
                document.getElementById('modalDetalhesBody').innerHTML = '<div class="alert alert-danger">Usuário não encontrado.</div>';
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

        // Inicializar notificações
        document.addEventListener('DOMContentLoaded', function() {
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top'
                },
                duration: 3000,
                ripple: true,
                dismissible: false
            });

            // Mostrar mensagens de sessão
            <?php if (isset($_SESSION['mensagem'])): ?>
                notyf.<?= $_SESSION['tipo_mensagem'] === 'error' ? 'error' : 'success' ?>('<?= $_SESSION['mensagem'] ?>');
                <?php
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>
        });
    </script>
</body>

</html>