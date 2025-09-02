<?php
session_start();
require_once '../Conexao/conexao.php';

//verifica se o usuario tem permissao 
//supondo que o perfil 1 seja o administrador

if ($_SESSION['perfil'] != 1) {
  echo "Acesso Negado!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_usuario = $_POST['id_usuario'];
  $email = $_POST['email_cliente'];
  $nome = $_POST['nome_cliente'];
  $data_nasc = $_POST['data_nasc'];
  $data_cad = $_POST['data_cad'];
  $sexo = $_POST['sexo_cliente'];
  $cep = $_POST['cep_cliente'];
  $logradouro = $_POST['logradouro_cliente'];
  $tipo = $_POST['tipo_casa'];
  $complemento = $_POST['complemento_cliente'];
  $numero = $_POST['numero_cliente'];
  $cidade = $_POST['cidade_cliente'];
  $telefone = $_POST['telefone_cliente'];
  $uf = $_POST['uf_cliente'];
  $bairro = $_POST['bairro_cliente'];

  $sql = "INSERT INTO cliente(
    id_usuario,email,nome,observacao,data_nasc,data_cad,sexo,cep,logradouro,tipo,complemento,numero,cidade,telefone,uf,bairro
) VALUES (
    :id_usuario,:email,:nome,:observacao,:data_nasc,:data_cad,:sexo,:cep,:logradouro,:tipo,:complemento,:numero,:cidade,:telefone,:uf,:bairro
)
";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id_usuario', $id_usuario);
  $stmt->bindParam(':email', $email);
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

  if ($stmt->execute()) {
    echo "<script>
        alert('Cliente cadastrado com sucesso!');
        window.location.href = 'cliente.php';
    </script>";
  } else {
    echo "<script>alert('Erro ao cadastrar cliente');</script>";
  }
}
?>