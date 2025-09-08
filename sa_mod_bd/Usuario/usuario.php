<?php
session_start();
require_once("../Conexao/conexao.php");

if($_SESSION['perfil'] !=1){
  echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Funcionários</title>

  <!-- Links bootstrap e css -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <link rel="stylesheet" href="css_usuario.css">

  <!-- Imagem no navegador -->
  <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

</head>

<body>
  <div class="container">
    <h1>CADASTRO DE FUNCIONÁRIOS</h1>
    
    <?php include("../Menu_lateral/menu.php"); ?>
    
    <form method="POST" action="cadastrar_usuario.php">
      <div class="form-section">
        <h2>Dados Pessoais</h2>
        
        <div class="campo_usuario">
          <div class="linha">
            <label for="nome_usuario">Nome:</label>
            <input type="text" id="nome_usuario" name="nome_usuario" class="form-control" placeholder="Nome" required>
          </div>

          <div class="linha">
            <label for="username">Nome de usuário:</label>
            <input type="text" id="username" name="username" class="form-control"
              placeholder="Nome de usuário" required>
          </div>

          <div class="linha">
            <label for="email_usuario">Email:</label>
            <input type="email" id="email_usuario" name="email_usuario" class="form-control"
              placeholder="Exemplo123@gmail.com" required>
          </div>

          <div class="linha">
            <label for="senha_usuario">Senha:</label>
            <input type="password" id="senha_usuario" name="senha_usuario" class="form-control"
              placeholder="Digite a senha" required>
          </div>

          <div class="linha">
            <label for="cargo_usuario">Cargo do Funcionário:</label>
            <select id="cargo_usuario" name="cargo_usuario" class="form-control" required>
              <option value="">Selecione</option>
              <option value="1">Administrador</option>
              <option value="2">Atendente</option>
              <option value="3">Técnico</option>
              <option value="4">Financeiro</option>
              <option value="5">Almoxarife</option>
            </select>
          </div>

          <div class="linha">
            <label for="cpf_usuario">CPF:</label>
            <input type="text" id="cpf_usuario" name="cpf_usuario" class="form-control"
              placeholder="000.000.000-00" required>
          </div>

          <div class="linha">
            <label for="dataNascimento">Data Nascimento:</label>
            <input type="text" id="dataNascimento" name="dataNascimento" class="form-control"
              placeholder="Data de Nascimento" required>
          </div>

          <div class="linha">
            <label for="dataCadastro">Data Cadastro:</label>
            <input type="text" id="dataCadastro" name="dataCadastro" class="form-control"
              placeholder="Data de Cadastro" required>
          </div>

          <div class="linha">
            <label for="sexo_usuario">Sexo:</label>
            <select id="sexo_usuario" name="sexo_usuario" class="form-control" required>
              <option value="">Selecione</option>
              <option value="M">Masculino</option>
              <option value="F">Feminino</option>
            </select>
          </div>

          <div class="linha">
            <label for="telefone_usuario">Telefone:</label>
            <input type="tel" id="telefone_usuario" name="telefone_usuario" class="form-control"
              placeholder="(00) 00000-0000" required>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h2>Endereço</h2>
        
        <div class="campo_usuario">
          <div class="linha">
            <label for="cep_usuario">CEP:</label>
            <input type="text" id="cep_usuario" name="cep_usuario" class="form-control" maxlength="10"
              placeholder="00000-000" required>
          </div>

          <div class="linha">
            <label for="logradouro_usuario">Logradouro:</label>
            <input type="text" id="logradouro_usuario" name="logradouro_usuario" class="form-control"
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
            <label for="uf_usuario">Estado (UF):</label>
            <select id="uf_usuario" name="uf_usuario" class="form-control" required>
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
            <label for="numero_usuario">Número:</label>
            <input type="number" id="numero_usuario" name="numero_usuario" class="form-control"
              placeholder="Número" required>
          </div>

          <div class="linha">
            <label for="cidade_usuario">Cidade:</label>
            <input type="text" id="cidade_usuario" name="cidade_usuario" class="form-control"
              placeholder="Cidade" required>
          </div>

          <div class="linha">
            <label for="bairro_usuario">Bairro:</label>
            <input type="text" id="bairro_usuario" name="bairro_usuario" class="form-control"
              placeholder="Bairro" required>
          </div>

          <div class="linha">
            <label for="complemento_usuario">Complemento:</label>
            <input type="text" id="complemento_usuario" name="complemento_usuario" class="form-control"
              placeholder="Complemento">
          </div>
        </div>
      </div>

      <div class="container-botoes">
        <button type="reset" class="btn btn-limpar">Cancelar</button>
        <button type="submit" class="btn btn-enviar" onclick="return conferirCampos()">
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
  <script src="usuario.js"></script>
  
  <script>
    const notyf = new Notyf({
      duration: 4000,
      position: { x: 'right', y: 'top' },
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
      notyf.success('Usuário cadastrado com sucesso!');
    <?php else: ?>
      notyf.error('Erro ao cadastrar cliente.');
    <?php endif; ?>
  </script>
  <?php unset($_SESSION['msg']); ?>

  

</body>
</html>