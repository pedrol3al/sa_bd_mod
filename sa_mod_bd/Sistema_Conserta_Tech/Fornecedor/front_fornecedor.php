<?php
session_start();
require_once("../Conexao/conexao.php");

if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3) {
  echo "<script>alert('Acesso negado!');window.location.href='../Login/index.php'</script>";
  exit();
}

$sql = "SELECT id_usuario, nome FROM usuario WHERE inativo = 0 ORDER BY nome";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll();

// Processar o cadastro do fornecedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../Conexao/conexao.php");
    
    $email = $_POST["email_forn"];
    $id_usuario = $_POST["id_usuario"];
    $razao_social = $_POST["razao_social_forn"];
    $cnpj = $_POST["cnpj_forn"];
    $data_fundacao = $_POST["dataFundacao_forn"];
    $data_cadastro = $_POST["dataCadastro_forn"];
    $telefone = $_POST["telefone_forn"];
    $produto_fornecido = $_POST["produto_fornecido"];
    $cep = $_POST["cep_forn"];
    $logradouro = $_POST["logradouro_forn"];
    $tipo = $_POST["tipo_estabelecimento_forn"];
    $complemento = $_POST["complemento_forn"];
    $numero = $_POST["numero_forn"];
    $cidade = $_POST["cidade_forn"];
    $uf = $_POST["uf_forn"];
    $bairro = $_POST["bairro_forn"];
    $observacoes = $_POST["observacoes_forn"];

    $sql = "INSERT INTO fornecedor (email, id_usuario, razao_social, cnpj, data_fundacao, data_cad, telefone, produto_fornecido, cep, logradouro, tipo, complemento, numero, cidade, uf, bairro, observacoes)
            VALUES (:email, :id_usuario, :razao_social, :cnpj, :data_fundacao, :data_cadastro, :telefone, :produto_fornecido, :cep, :logradouro, :tipo, :complemento, :numero, :cidade, :uf, :bairro, :observacoes)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':razao_social', $razao_social);
    $stmt->bindParam(':cnpj', $cnpj);
    $stmt->bindParam(':data_fundacao', $data_fundacao);
    $stmt->bindParam(':data_cadastro', $data_cadastro);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':produto_fornecido', $produto_fornecido);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':logradouro', $logradouro);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':complemento', $complemento);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':uf', $uf);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':observacoes', $observacoes);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Fornecedor cadastrado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
    } else {
        $_SESSION['mensagem'] = 'Erro ao cadastrar fornecedor!';
        $_SESSION['tipo_mensagem'] = 'danger';
    }
    
    // Redirecionar para a mesma página para evitar reenvio do formulário
    header('Location: ' . $_SERVER['PHP_SELF']);
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
  
  <style>
    :root {
      --primary-color: #2c3e50;
      --secondary-color: #3498db;
      --background-color: #ecf0f1;
      --text-color: #2c3e50;
      --border-color: #bdc3c7;
      --success-color: #27ae60;
      --danger-color: #e74c3c;
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
      margin: 20px auto;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-left: 290px;
    }
    
    h1 {
      color: var(--primary-color);
      margin-bottom: 20px;
      border-bottom: 2px solid var(--secondary-color);
      padding-bottom: 10px;
      text-align: center;
    }
    
    .form-section {
      margin-bottom: 30px;
      border: 1px solid var(--border-color);
      padding: 15px;
      border-radius: 5px;
    }
    
    .form-section h2 {
      color: var(--primary-color);
      margin-bottom: 15px;
      padding-bottom: 5px;
      border-bottom: 1px solid var(--border-color);
    }
    
    .campo_fornecedor {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 15px;
    }
    
    .linha {
      margin-bottom: 15px;
    }
    
    .linha label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
    }
    
    .linha input, 
    .linha select, 
    .linha textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      font-size: 14px;
    }
    
    .btn {
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: 600;
      margin-right: 10px;
    }
    
    .btn-enviar {
      background-color: var(--success-color);
      color: white;
    }
    
    .btn-limpar {
      background-color: var(--danger-color);
      color: white;
    }
    
    .container-botoes {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 20px;
      padding-top: 15px;
      border-top: 1px solid var(--border-color);
    }
    
    /* Ajuste para telas menores */
    @media (max-width: 992px) {
      .container {
        margin-left: 20px;
        margin-right: 20px;
      }
      
      .campo_fornecedor {
        grid-template-columns: 1fr;
      }
      
      .container-botoes {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>CADASTRO DE FORNECEDOR</h1>
    
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
            <input type="text" id="cnpj_forn" name="cnpj_forn" class="form-control"
              placeholder="00.000.000/0000-00" required>
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
            <input type="text" id="cep_forn" name="cep_forn" class="form-control" maxlength="10"
              placeholder="00000-000" required>
          </div>

          <div class="linha">
            <label for="logradouro_forn">Logradouro:</label>
            <input type="text" id="logradouro_forn" name="logradouro_forn" class="form-control"
              placeholder="Logradouro" required>
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
            <textarea id="observacoes_forn" name="observacoes_forn" class="form-control" rows="3" placeholder="Observações"></textarea>
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
  
  <script>
    // Aplicar máscaras aos campos
    $(document).ready(function(){
      $('#cnpj_forn').mask('00.000.000/0000-00');
      $('#telefone_forn').mask('(00) 00000-0000');
      $('#cep_forn').mask('00000-000');
      
      // Inicializar datepickers
      $("#dataFundacao_forn").flatpickr({
        dateFormat: "d/m/Y",
        allowInput: true
      });
      
      $("#dataCadastro_forn").flatpickr({
        dateFormat: "d/m/Y",
        allowInput: true,
        defaultDate: "today"
      });
      
      // Buscar endereço pelo CEP
      $('#cep_forn').on('blur', function() {
        var cep = $(this).val().replace(/\D/g, '');
        
        if (cep.length === 8) {
          $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
            if (!data.erro) {
              $('#logradouro_forn').val(data.logradouro);
              $('#bairro_forn').val(data.bairro);
              $('#cidade_forn').val(data.localidade);
              $('#uf_forn').val(data.uf);
              $('#numero_forn').focus();
            }
          });
        }
      });
    });
    
    function conferirCampos() {
      // Sua lógica de validação aqui
      return true;
    }
  </script>
</body>
</html>