<?php
// alterar_usuario_frontend.php
// Inclui o backend primeiro para ter acesso às variáveis
include 'processa_alteracao.php';
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

    <link rel="stylesheet" href="alterar.css">

</head>

<body>
    <div class="container">
        <h1>ALTERAR USUÁRIOS</h1>

        <?php include("../Menu_lateral/menu.php"); ?>


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
                <?php if (!empty($usuarios)): ?>
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
                                        default:
                                            $perfil_text = $usuario['id_perfil'];
                                            $perfil_class = '';
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
                                            <a class="btn btn-warning btn-sm"
                                                href="alterar_usuario.php?id=<?= safe_html($usuario['id_usuario']) ?>">
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
        <?php if ($usuarioAtual): ?>
            <div class="form-section">
                <h2>Editar Usuário: <?= safe_html($usuarioAtual['nome']) ?></h2>

                <form method="POST">
                    <input type="hidden" name="id_usuario" value="<?= safe_html($usuarioAtual['id_usuario']) ?>">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="perfil">Perfil:</label>
                            <select id="perfil" name="perfil" class="form-control" required>
                                <option value="1" <?= $usuarioAtual['id_perfil'] == 1 ? 'selected' : '' ?>>Administrador
                                </option>
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
                                $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
                                foreach ($ufs as $uf) {
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

                        <?php if ($usuarioAtual['inativo'] == 0): ?>
                            <a href="buscar_usuario.php?inativar=<?= $usuarioAtual['id_usuario'] ?>" class="btn btn-danger"
                                onclick="return confirm('Tem certeza que deseja inativar este usuário?')">
                                <i class="bi bi-person-x"></i> Inativar Usuário
                            </a>
                        <?php else: ?>
                            <a href="buscar_usuario.php?ativar=<?= $usuarioAtual['id_usuario'] ?>" class="btn btn-success"
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
        $(document).ready(function () {
            // Inicializar Notyf centralizado no topo
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

            // Aplicar máscaras aos campos
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 00000-0000');
            $('#cep').mask('00000-000');

            // Buscar endereço pelo CEP
            $('#cep').on('blur', function () {
                var cep = $(this).val().replace(/\D/g, '');

                if (cep.length === 8) {
                    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
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