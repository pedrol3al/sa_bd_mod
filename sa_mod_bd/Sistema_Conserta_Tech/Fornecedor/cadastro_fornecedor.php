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
        
        
        
            // ---------- INSERT fornecedor ----------
            $sqlFornecedor = "INSERT INTO fornecedor 
            (razao_social, email, cnpj, data_fundacao, foto_fornecedor, observacoes,
             cep, logradouro, tipo_estabelecimento, complemento, numero, cidade, uf, bairro, telefone)
            VALUES (:razao_social, :email, :cnpj, :data_fundacao, :observacoes,
                    :cep, :logradouro, :tipo_estabelecimento, :complemento, :numero, :cidade, :uf, :bairro, :telefone)";
        
        $stmt = $pdo->prepare($sqlFornecedor);
        $stmt->execute([
            ':razao_social'        => $_POST['razao_social_forn'],
            ':email'               => $_POST['email_forn'],
            ':cnpj'                => $_POST['cnpj_forn'],
            ':data_fundacao'       => $_POST['dataFundacao_forn'],
            ':foto_fornecedor'     => $foto_fornecedor,
            ':observacoes'         => $_POST['observacoes_forn'],
            ':cep'                 => $_POST['cep_forn'],
            ':logradouro'          => $_POST['logradouro_forn'],
            ':tipo_estabelecimento'=> $_POST['tipo_estabelecimento_forn'],
            ':complemento'         => $_POST['complemento_forn'],
            ':numero'              => $_POST['numero_forn'],
            ':cidade'              => $_POST['cidade_forn'],
            ':uf'                  => $_POST['uf_forn'],
            ':bairro'              => $_POST['bairro_forn'],
            ':telefone'            => $_POST['telefone_forn']
        ]);
        
        echo "
        <link rel='stylesheet' href='../assets/css/notyf.min.css'>
        <script src='../assets/js/notyf.min.js'></script>
        <script>
            var notyf = new Notyf();
            notyf.success('Fornecedor cadastrado com sucesso!');
            setTimeout(function(){
                window.location.href = 'front_fornecedor.php';
            }, 2000);
        </script>
        ";
        
        }
    } catch (Exception $e) {
        $pdo->rollBack(); // desfaz tudo se deu erro
        echo "Erro no cadastro: " . $e->getMessage();
    }
    ?>
