    <?php
    session_start();
    require_once("../Conexao/conexao.php");


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email_forn"];
        $razao_social = $_POST["razao_social_forn"];
        $cnpj = $_POST["cnpj_forn"];
        $data_fundacao = $_POST["dataFundacao_forn"];
        $produto_fornecido = $_POST["produto_fornecido"];
        $cep = $_POST["cep_forn"];
        $logradouro = $_POST["logradouro_forn"];
        $tipo = $_POST["tipo_estabelecimento_forn"];
        $complemento = $_POST["complemento_forn"];
        $numero = $_POST["numero_forn"];
        $cidade = $_POST["cidade_forn"];
        $uf = $_POST["uf_forn"];
        $bairro = $_POST["bairro_forn"];

        $sql = "INSERT INTO fornecedor (email, razao_social, cnpj, data_fundacao, produto_fornecido, cep, logradouro, tipo, complemento, numero, cidade, uf, bairro)
                VALUES (:email, :razao_social, :cnpj, :data_fundacao, :produto_fornecido, :cep, :logradouro, :tipo, :complemento, :numero, :cidade, :uf, :bairro)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':razao_social', $razao_social);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':data_fundacao', $data_fundacao);
        $stmt->bindParam(':produto_fornecido', $produto_fornecido);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':complemento', $complemento);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':uf', $uf);
        $stmt->bindParam(':bairro', $bairro);

        if ($stmt->execute()) {
            echo "<script>alert('Fornecedor cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar fornecedor!');</script>";
        }
    }
    ?>
