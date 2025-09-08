<?php
session_start();
require_once("../Conexao/conexao.php");
require_once("fornecedor_cad.php");

if ($_SESSION['perfil'] != 1) {
  echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php'</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Fornecedor</title>

  <!-- Links bootstrap e css -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

  <!-- Imagem no navegador -->
  <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

  <link rel="stylesheet" href="fornecedor_cad.css">

</head>

<body>
  <div class="container">
    <h1>CADASTRO DE FORNECEDOR</h1>

    <?php include("../Menu_lateral/menu.php"); ?>

    <form method="post" action="">
      <div class="form-section">
        <h2>Dados do Fornecedor</h2>

        <div class="campo_fornecedor">
          <div class="linha">
            <label for="razao_social_forn">Razão Social:</label>
            <input type="text" id="razao_social_forn" name="razao_social_forn" class="form-control"
              placeholder="Razão Social" required>
          </div>

          <div class="linha">
            <label for="id_usuario">Id do usuário</label>
            <select id="id_usuario" name="id_usuario" class="form-control" required>
              <option value="">Selecione um usuário</option>
              <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id_usuario'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="linha">
            <label for="cnpj_forn">CNPJ:</label>
            <input type="text" id="cnpj_forn" name="cnpj_forn" class="form-control" placeholder="00.000.000/0000-00"
              required>
          </div>

          <div class="linha">
            <label for="dataFundacao_forn">Data de fundação:</label>
            <input type="text" id="dataFundacao_forn" name="dataFundacao_forn" class="form-control"
              placeholder="Data de fundação">
          </div>

          <div class="linha">
            <label for="dataCadastro_forn">Data de Cadastro:</label>
            <input type="text" id="dataCadastro_forn" name="dataCadastro_forn" class="form-control"
              placeholder="Data de cadastro" required>
          </div>

          <div class="linha">
            <label for="telefone_forn">Telefone:</label>
            <input type="text" id="telefone_forn" name="telefone_forn" class="form-control"
              placeholder="(00) 00000-0000" required>
          </div>

          <div class="linha">
            <label for="email_forn">Email:</label>
            <input type="email" id="email_forn" name="email_forn" class="form-control"
              placeholder="Exemplo@corporacao.com.br" required>
          </div>

          <div class="linha">
            <label for="produto_fornecido">Produto fornecido:</label>
            <input type="text" id="produto_fornecido" name="produto_fornecido" class="form-control"
              placeholder="Produto fornecido" required>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h2>Endereço</h2>

        <div class="campo_fornecedor">
          <div class="linha">
            <label for="cep_forn">CEP:</label>
            <input type="text" id="cep_forn" name="cep_forn" class="form-control" maxlength="10" placeholder="00000-000"
              required>
          </div>

          <div class="linha">
            <label for="logradouro_forn">Logradouro:</label>
            <input type="text" id="logradouro_forn" name="logradouro_forn" class="form-control" placeholder="Logradouro"
              required>
          </div>

          <div class="linha">
            <label for="tipo_estabelecimento_forn">Tipo de estabelecimento:</label>
            <select id="tipo_estabelecimento_forn" name="tipo_estabelecimento_forn" class="form-control" required>
              <option value="">Selecione</option>
              <option value="R">Residencial</option>
              <option value="C">Comercial</option>
            </select>
          </div>

          <div class="linha">
            <label for="uf_forn">Estado (UF):</label>
            <select id="uf_forn" name="uf_forn" class="form-control" required>
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
            <label for="numero_forn">Número:</label>
            <input type="number" id="numero_forn" name="numero_forn" class="form-control" placeholder="Número" required>
          </div>

          <div class="linha">
            <label for="cidade_forn">Cidade:</label>
            <input type="text" id="cidade_forn" name="cidade_forn" class="form-control" placeholder="Cidade" required>
          </div>

          <div class="linha">
            <label for="bairro_forn">Bairro:</label>
            <input type="text" id="bairro_forn" name="bairro_forn" class="form-control" placeholder="Bairro" required>
          </div>

          <div class="linha">
            <label for="complemento_forn">Complemento:</label>
            <input type="text" id="complemento_forn" name="complemento_forn" class="form-control"
              placeholder="Complemento">
          </div>
        </div>
      </div>

      <div class="form-section">
        <h2>Outras Informações</h2>

        <div class="campo_fornecedor">
          <div class="linha" style="grid-column: 1 / -1;">
            <label for="observacoes_forn">Observações:</label>
            <textarea id="observacoes_forn" name="observacoes_forn" class="form-control" rows="3"
              placeholder="Observações"></textarea>
          </div>
        </div>
      </div>

      <div class="container-botoes">
        <button type="reset" class="btn btn-limpar">Limpar</button>
        <button type="submit" class="btn btn-enviar">
          <i class="bi bi-check-circle"></i> Cadastrar
        </button>
      </div>
    </form>
  </div>

  <!-- Links JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <script src="../Menu_lateral/carregar-menu.js" defer></script>
  <script src="fornecedor.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Configurar Notyf para centralizar no topo
      const notyf = new Notyf({
        duration: 4000,
        position: {
          x: 'right',
          y: 'top'
        },
        types: [
          {
            type: 'success',
            background: '#28a745',
            icon: {
              className: 'bi bi-check-circle-fill',
              tagName: 'i',
              text: ''
            }
          },
          {
            type: 'error',
            background: '#dc3545',
            icon: {
              className: 'bi bi-x-circle-fill',
              tagName: 'i',
              text: ''
            }
          }
        ]
      });
    }
    )
    // Mostrar mensagens de sessão
    <?php if (isset($_SESSION['mensagem'])): ?>
      <?php if ($_SESSION['tipo_mensagem'] == 'success'): ?>
        notyf.success('<?= $_SESSION['mensagem'] ?>');
      <?php elseif ($_SESSION['tipo_mensagem'] == 'error'): ?>
        notyf.error('<?= $_SESSION['mensagem'] ?>');
      <?php endif; ?>

      <?php
      // Limpar a mensagem após exibir
      unset($_SESSION['mensagem']);
      unset($_SESSION['tipo_mensagem']);
      ?>
    <?php endif; ?>




  </script>
</body>

</html>