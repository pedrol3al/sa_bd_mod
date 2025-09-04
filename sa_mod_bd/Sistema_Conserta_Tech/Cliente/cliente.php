<?php
session_start();
require_once("../Conexao/conexao.php");
  // Buscar técnicos (usuários com perfil 3)
    $sql = "SELECT id_usuario, nome FROM usuario WHERE inativo = 0 ORDER BY nome";
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
      max-width: 1200px;
      margin: 0 auto;
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
    
    .campo_cliente {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }
    
    .linha {
      flex: 1;
      min-width: 200px;
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
    
    .btn-success {
      background-color: var(--success-color);
      color: white;
    }
    
    .btn-danger {
      background-color: var(--danger-color);
      color: white;
    }
    
    .actions {
      display: flex;
      justify-content: flex-end;
      margin-top: 20px;
    }
  </style>
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
            <label for="cpf_cliente">CPF:</label>
            <input type="text" id="cpf_cliente" name="cpf_cliente" class="form-control"
              placeholder="000.000.000-00" required>
          </div>

          <div class="linha">
            <label for="data_nasc">Data Nascimento:</label>
            <input type="text" id="data_nasc" name="data_nasc" class="form-control"
              placeholder="Data de Nascimento" required>
          </div>

          <div class="linha">
            <label for="data_cad">Data Cadastro:</label>
            <input type="text" id="data_cad" name="data_cad" class="form-control"
              placeholder="Data de Cadastro" required>
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
            <input type="number" id="numero_cliente" name="numero_cliente" class="form-control"
              placeholder="Número" required>
          </div>

          <div class="linha">
            <label for="cidade_cliente">Cidade:</label>
            <input type="text" id="cidade_cliente" name="cidade_cliente" class="form-control"
              placeholder="Cidade" required>
          </div>

          <div class="linha">
            <label for="bairro_cliente">Bairro:</label>
            <input type="text" id="bairro_cliente" name="bairro_cliente" class="form-control"
              placeholder="Bairro" required>
          </div>

          <div class="linha">
            <label for="complemento_cliente">Complemento:</label>
            <input type="text" id="complemento_cliente" name="complemento_cliente" class="form-control"
              placeholder="Complemento">
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

  <script>
    // Aplicar máscaras aos campos
    $(document).ready(function(){
      $('#cpf_cliente').mask('000.000.000-00');
      $('#telefone_cliente').mask('(00) 00000-0000');
      $('#cep_cliente').mask('00000-000');
      
      $("#data_cad").flatpickr({
        dateFormat: "d/m/Y",
        allowInput: true,
    });
  });
    
    function conferirCampos() {
      // Sua lógica de validação aqui
      return true;
    }
  </script>
</body>
</html>