<?php
// buscar_os_backend.php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php'</script>";
    exit();
}

// Função auxiliar para evitar erros com valores nulos
function safe_html($value) {
    return $value !== null ? htmlspecialchars($value) : '';
}

// Processar busca
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$ordens_servico = [];

try {
    $sql = "SELECT os.id, os.data_criacao, os.data_termino, os.status, 
                   c.nome as cliente_nome, c.id_cliente, c.telefone as cliente_telefone,
                   u.nome as tecnico_nome, u.id_usuario,
                   COALESCE(SUM(s.valor), 0) as valor_total,
                   COALESCE(SUM(p.valor_total), 0) as valor_pago,
                   os.observacoes
            FROM ordens_servico os
            INNER JOIN cliente c ON os.id_cliente = c.id_cliente
            INNER JOIN usuario u ON os.id_usuario = u.id_usuario
            LEFT JOIN equipamentos_os e ON os.id = e.id_os
            LEFT JOIN servicos_os s ON e.id = s.id_equipamento
            LEFT JOIN pagamento p ON os.id = p.id_os";
    
    if (!empty($search)) {
        $sql .= " WHERE (";
        $sql .= "c.nome = :search_exact OR "; // Busca exata
        $sql .= "c.nome LIKE CONCAT(:search_start, ' %') OR "; // Nome que começa com
        $sql .= "c.nome LIKE CONCAT('% ', :search_end) OR "; // Nome que termina com
        $sql .= "c.nome LIKE CONCAT('% ', :search_middle, ' %') OR "; // Nome que contém como palavra separada
        $sql .= "os.id = :search_id OR "; // ID exato
        $sql .= "os.status LIKE CONCAT('%', :search_status, '%')"; // Status parcial
        $sql .= ")";
    }
    
    $sql .= " GROUP BY os.id ORDER BY os.data_criacao DESC";
    
    $stmt = $pdo->prepare($sql);
    
    if (!empty($search)) {
        // Prepara os parâmetros para a busca
        $search_exact = $search;
        $search_start = $search;
        $search_end = $search;
        $search_middle = $search;
        $search_id = $search;
        $search_status = $search;
        
        // Bind dos parâmetros
        $stmt->bindParam(':search_exact', $search_exact);
        $stmt->bindParam(':search_start', $search_start);
        $stmt->bindParam(':search_end', $search_end);
        $stmt->bindParam(':search_middle', $search_middle);
        $stmt->bindParam(':search_id', $search_id);
        $stmt->bindParam(':search_status', $search_status);
    }
    
    $stmt->execute();
    $ordens_servico = $stmt->fetchAll();
    
} catch (PDOException $e) {
    echo "Erro ao buscar OS: " . $e->getMessage();
}

// Converter dados para JSON para uso no JavaScript
$ordens_servico_json = json_encode($ordens_servico);
?>