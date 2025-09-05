<?php
session_start();
require_once("../Conexao/conexao.php");



if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
  echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
  exit();
}


// Buscar os usuarios administradores e atendente
$sql = "SELECT id_usuario, nome FROM usuario WHERE inativo = 0 AND (id_perfil = 1 OR id_perfil = 2)
    ORDER BY nome";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Clientes</title>

  <!-- Links CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />

  <!-- Imagem no navegador -->
  <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

  <link rel="stylesheet" href="cliente.css  ">

</head>

<body>
  <?php include("../Menu_lateral/menu.php"); ?>

  <div class="container">
    <form method="POST" action="back_cad_cliente.php">
      <h1>CADASTRO DE CLIENTES</h1>

      <div class="form-section">
        <h2>Dados:</h2>

        <div class="campo_cliente">
          <div class="linha">
            <label for="nome_cliente">Nome:</label>
            <input type="text" id="nome_cliente" name="nome_cliente" class="form-control" placeholder="Nome" required>
          </div>

          <div class="linha">
            <label for="id_usuario">Usuario de cadastro:</label>
            <select id="id_usuario" name="id_usuario" class="form-control" required>
              <option value="">Selecione um usuário</option>
              <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id_usuario'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="linha">
            <label for="email_cliente">Email:</label>
            <input type="email" id="email_cliente" name="email_cliente" class="form-control"
              placeholder="Exemplo123@gmail.com" required>
          </div>

          <div class="linha">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00" required>
          </div>

          <div class="linha">
            <label for="data_nasc">Data Nascimento:</label>
            <input type="text" id="data_nasc" name="data_nasc" class="form-control" placeholder="Data de Nascimento"
              required>
          </div>

          <div class="linha">
            <label for="data_cad">Data Cadastro:</label>
            <input type="text" id="data_cad" name="data_cad" class="form-control" placeholder="Data de Cadastro"
              required>
          </div>

          <div class="linha">
            <label for="sexo_cliente">Sexo:</label>
            <select id="sexo_cliente" name="sexo_cliente" class="form-control" required>
              <option value="">Selecione</option>
              <option value="M">Masculino</option>
              <option value="F">Feminino</option>
            </select>
          </div>

          <div class="linha">
            <label for="telefone_cliente">Telefone:</label>
            <input type="tel" id="telefone_cliente" name="telefone_cliente" class="form-control"
              placeholder="(00) 00000-0000" required>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h2>Endereço</h2>

        <div class="campo_cliente">
          <div class="linha">
            <label for="cep_cliente">CEP:</label>
            <input type="text" id="cep_cliente" name="cep_cliente" class="form-control" maxlength="10"
              placeholder="00000-000" required>
          </div>

          <div class="linha">
            <label for="logradouro_cliente">Logradouro:</label>
            <input type="text" id="logradouro_cliente" name="logradouro_cliente" class="form-control"
              placeholder="Logradouro" required>
          </div>

          <div class="linha">
            <label for="tipo_casa">Tipo de moradia:</label>
            <select id="tipo_casa" name="tipo_casa" class="form-control" required>
              <option value="">Selecione</option>
              <option value="R">Residencial</option>
              <option value="C">Comercial</option>
            </select>
          </div>

          <div class="linha">
            <label for="uf_cliente">Estado (UF):</label>
            <select id="uf_cliente" name="uf_cliente" class="form-control" required>
              <option value="">Selecione</option>
              <option value="AC">Acre</option>
              <option value="AL">Alagoas</option>
              <option value="AP">Amapá</option>
              <option value="AM">Amazonas</option>
              <option value="BA">Bahia</option>
              <option value="CE">Ceará</option>
              <option value="DF">Distrito Federal</option>
              <option value="ES">Espírito Santo</option>
              <option value="GO">Goiás</option>
              <option value="MA">Maranhão</option>
              <option value="MT">Mato Grosso</option>
              <option value="MS">Mato Grosso do Sul</option>
              <option value="MG">Minas Gerais</option>
              <option value="PA">Pará</option>
              <option value="PB">Paraíba</option>
              <option value="PR">Paraná</option>
              <option value="PE">Pernambuco</option>
              <option value="PI">Piauí</option>
              <option value="RJ">Rio de Janeiro</option>
              <option value="RN">Rio Grande do Norte</option>
              <option value="RS">Rio Grande do Sul</option>
              <option value="RO">Rondônia</option>
              <option value="RR">Roraima</option>
              <option value="SC">Santa Catarina</option>
              <option value="SP">São Paulo</option>
              <option value="SE">Sergipe</option>
              <option value="TO">Tocantins</option>
            </select>
          </div>

          <div class="linha">
            <label for="numero_cliente">Número:</label>
            <input type="number" id="numero_cliente" name="numero_cliente" class="form-control" placeholder="Número"
              required>
          </div>

          <div class="linha">
            <label for="cidade_cliente">Cidade:</label>
            <input type="text" id="cidade_cliente" name="cidade_cliente" class="form-control" placeholder="Cidade"
              required>
          </div>

          <div class="linha">
            <label for="bairro_cliente">Bairro:</label>
            <input type="text" id="bairro_cliente" name="bairro_cliente" class="form-control" placeholder="Bairro"
              required>
          </div>

          <div class="linha">
            <label for="complemento_cliente">Complemento:</label>
            <input type="text" id="complemento_cliente" name="complemento_cliente" class="form-control"
              placeholder="Complemento">
          </div>
        </div>
      </div>

      <div class="form-section">
        <h2>Outras Informações</h2>

        <div class="campo_fornecedor">
          <div class="linha" style="grid-column: 1 / -1;">
            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes" class="form-control" rows="3"
              placeholder="Observações"></textarea>
          </div>
        </div>
      </div>

      <div class="actions">
        <button type="submit" id="enviar" class="btn btn-success" onclick="return conferirCampos()">
          Cadastrar
        </button>
        <button type="reset" id="limpar" class="btn btn-danger"> Cancelar </button>
      </div>
    </form>
  </div>

  <!-- Links JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <script src="cliente.js"></script>

  <?php if (isset($_SESSION['msg'])): ?>
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

  <script>
    const notyf = new Notyf({
      duration: 4000,
      position: { x: 'center', y: 'top' },
      types: [
        {
          type: 'success',
          background: '#28a745',
          icon: { className: 'bi bi-check-circle-fill', tagName: 'i', text: '' }
        },
        {
          type: 'error',
          background: '#dc3545',
          icon: { className: 'bi bi-x-circle-fill', tagName: 'i', text: '' }
        }
      ]
    });

    <?php if ($_SESSION['msg'] === "success"): ?>
      notyf.success('Cadastro realizado com sucesso!');
    <?php else: ?>
      notyf.error('Erro ao cadastrar cliente.');
    <?php endif; ?>
  </script>
  <?php unset($_SESSION['msg']); ?>
<?php endif; ?>


</body>

</html>