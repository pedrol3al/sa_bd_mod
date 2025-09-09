<?php
// Inicia a sessão para poder acessar variáveis de sessão
session_start();
// Inclui o arquivo de conexão com o banco de dados (usando require_once para incluir apenas uma vez)
require_once '../Conexao/conexao.php';

// Verifica se o formulário foi submetido via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtém os dados do formulário e armazena em variáveis
  $id_usuario = $_POST['id_usuario'];          // ID do usuário responsável pelo cadastro
  $email = $_POST['email_cliente'];            // E-mail do cliente
  $cpf = $_POST['cpf'];                        // CPF do cliente
  $nome = $_POST['nome_cliente'];              // Nome completo do cliente
  $observacao = $_POST['observacoes'];         // Observações adicionais sobre o cliente
  $data_nasc = $_POST['data_nasc'];            // Data de nascimento do cliente
  $data_cad = $_POST['data_cad'];              // Data de cadastro do cliente
  $sexo = $_POST['sexo_cliente'];              // Sexo do cliente (M/F)
  $cep = $_POST['cep_cliente'];                // CEP do endereço
  $logradouro = $_POST['logradouro_cliente'];  // Logradouro do endereço
  $tipo = $_POST['tipo_casa'];                 // Tipo de residência (casa, apartamento, etc.)
  $complemento = $_POST['complemento_cliente'];// Complemento do endereço
  $numero = $_POST['numero_cliente'];          // Número do endereço
  $cidade = $_POST['cidade_cliente'];          // Cidade do endereço
  $telefone = $_POST['telefone_cliente'];      // Telefone do cliente
  $uf = $_POST['uf_cliente'];                  // UF (Estado) do endereço
  $bairro = $_POST['bairro_cliente'];          // Bairro do endereço

  // Query SQL para inserir um novo cliente na tabela
  $sql = "INSERT INTO cliente(
      id_usuario,email,cpf,nome,observacao,data_nasc,data_cad,sexo,cep,logradouro,tipo,complemento,numero,cidade,telefone,uf,bairro
  ) VALUES (
      :id_usuario,:email,:cpf,:nome,:observacao,:data_nasc,:data_cad,:sexo,:cep,:logradouro,:tipo,:complemento,:numero,:cidade,:telefone,:uf,:bairro
  )";
  
  // Prepara a query para execução (usando prepared statements para segurança)
  $stmt = $pdo->prepare($sql);
  
  // Associa os parâmetros da query aos valores das variáveis (bind)
  // Isso previne SQL injection e garante que os dados sejam tratados corretamente
  $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT); // Especifica que é um inteiro
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':cpf', $cpf);
  $stmt->bindParam(':nome', $nome);
  $stmt->bindParam(':observacao', $observacao);
  $stmt->bindParam(':data_nasc', $data_nasc);
  $stmt->bindParam(':data_cad', $data_cad);
  $stmt->bindParam(':sexo', $sexo);
  $stmt->bindParam(':cep', $cep);
  $stmt->bindParam(':logradouro', $logradouro);
  $stmt->bindParam(':tipo', $tipo);
  $stmt->bindParam(':complemento', $complemento);
  $stmt->bindParam(':numero', $numero);
  $stmt->bindParam(':cidade', $cidade);
  $stmt->bindParam(':telefone', $telefone);
  $stmt->bindParam(':uf', $uf);
  $stmt->bindParam(':bairro', $bairro);

  // Executa a query e verifica se foi bem-sucedida
  if ($stmt->execute()) {
      // Se a inserção foi bem-sucedida, define mensagem de sucesso na sessão
      $_SESSION['msg'] = "success";
  } else {
      // Se houve erro na inserção, define mensagem de erro na sessão
      $_SESSION['msg'] = "error";
  }

  // Redireciona de volta para a página cliente.php
  header("Location: cliente.php");
  exit(); // Encerra a execução do script
}
?>