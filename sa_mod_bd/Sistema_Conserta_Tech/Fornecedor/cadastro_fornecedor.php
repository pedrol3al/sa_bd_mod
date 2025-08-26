<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../Conexao/conexao.php');

// Perfil vazio ou diferente de administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
    die("Acesso Negado");
}

try {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $pdo->beginTransaction(); // inicia transação
     

        // ---------- UPLOAD DA FOTO ----------
        $foto_fornecedor = null;

        if (isset($_FILES['foto_fornecedor']) && $_FILES['foto_fornecedor']['error'] === UPLOAD_ERR_OK) {
            $arquivo_tmp = $_FILES['foto_fornecedor']['tmp_name'];
            $nome_arquivo = $_FILES['foto_fornecedor']['name'];

            // Pasta destino 
            $pasta_destino = 'uploads/';
            if (!is_dir($pasta_destino)) {
                mkdir($pasta_destino, 0755, true);
            }

            // Evita sobrescrever arquivos com o mesmo nome
            $nome_unico = time() . '_' . basename($nome_arquivo);
            $caminho_arquivo = $pasta_destino . $nome_unico;

            if (move_uploaded_file($arquivo_tmp, $caminho_arquivo)) {
                $foto_fornecedor = $caminho_arquivo;
            }
        }
      

        // ---------- INSERT fornecedor ----------
        $sqlFornecedor = "INSERT INTO fornecedor 
            (razao_social, email, cnpj, produto_fornecido, data_cad, data_fundacao, foto_fornecedor)
            VALUES (:razao_social, :email, :cnpj, :produto_fornecido, :data_cadastro, :data_fundacao, :foto_fornecedor)";

        $stmt = $pdo->prepare($sqlFornecedor);
        $stmt->execute([
            ':razao_social' => $_POST['razao_social'],
            ':email' => $_POST['email_fornecedor'], // corrigido
            ':cnpj' => $_POST['cnpj_fornecedor'],
            ':produto_fornecido' => $_POST['produto_fornecido'],
            ':data_cadastro' => $_POST['dataCadastro_fornecedor'],
            ':data_fundacao' => $_POST['dataFundacao_fornecedor'],
            ':foto_fornecedor' => $foto_fornecedor
        ]);

        

        // Pega o id do fornecedor gerado automaticamente pelo banco
        $id_fornecedor = $pdo->lastInsertId();

        // ---------- INSERT endereço ----------
        $sqlEndereco = "INSERT INTO endereco_fornecedor 
            (id_fornecedor, cep, logradouro, tipo_construcao, complemento, numero, cidade, uf, bairro)
            VALUES (:id_fornecedor, :cep, :logradouro, :tipo_construcao, :complemento, :numero, :cidade, :uf, :bairro)";

        $stmt = $pdo->prepare($sqlEndereco);
        $stmt->execute([
            ':id_fornecedor' => $id_fornecedor,
            ':cep' => $_POST['cep_fornecedor'],
            ':logradouro' => $_POST['logradouro_fornecedor'],
            ':tipo_construcao' => $_POST['tipo_construcao'],
            ':complemento' => $_POST['complemento'],
            ':numero' => $_POST['numero_fornecedor'],
            ':cidade' => $_POST['cidade_fornecedor'],
            ':uf' => $_POST['uf_fornecedor'],
            ':bairro' => $_POST['bairro_fornecedor'] // corrigido
        ]);
  

        // ---------- INSERT telefone ----------
        $sqlTelefone = "INSERT INTO telefone_fornecedor (id_fornecedor, telefone) 
                        VALUES (:id_fornecedor, :telefone_forn)";

        $stmt = $pdo->prepare($sqlTelefone);
        $stmt->execute([
            ':id_fornecedor' => $id_fornecedor,
            ':telefone_forn' => $_POST['telefone_forn'] // corrigido
        ]);
     

        $pdo->commit(); // confirma tudo
        echo "<script>alert('Fornecedor cadastrado com sucesso!');</script>";
    }
} catch (Exception $e) {
    $pdo->rollBack(); // desfaz tudo se deu erro
    echo "Erro no cadastro: " . $e->getMessage();
}
?>