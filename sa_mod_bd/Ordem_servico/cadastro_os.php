<?php
session_start();
require_once '../Conexao/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Inserir a ordem de serviço
        $sql_os = "INSERT INTO ordens_servico (id_cliente, id_usuario, data_termino, status, observacoes) 
                   VALUES (:id_cliente, :id_usuario, :data_termino, :status, :observacoes)";
        $stmt_os = $pdo->prepare($sql_os);
        $stmt_os->execute([
            ':id_cliente' => $_POST['id_cliente'],
            ':id_usuario' => $_POST['id_usuario'],
            ':data_termino' => $_POST['data_termino'] ?: null,
            ':status' => $_POST['status'],
            ':observacoes' => $_POST['observacoes']
        ]);

        $id_os = $pdo->lastInsertId();

        // Processar equipamentos e serviços
        if (isset($_POST['equipamentos'])) {
            foreach ($_POST['equipamentos'] as $equipamento) {
                // Inserir equipamento
                $sql_equip = "INSERT INTO equipamentos_os (id_os, fabricante, modelo, num_serie, num_aparelho, defeito_reclamado, condicao) 
                              VALUES (:id_os, :fabricante, :modelo, :num_serie, :num_aparelho, :defeito_reclamado, :condicao)";
                $stmt_equip = $pdo->prepare($sql_equip);
                $stmt_equip->execute([
                    ':id_os' => $id_os,
                    ':fabricante' => $equipamento['fabricante'],
                    ':modelo' => $equipamento['modelo'],
                    ':num_serie' => $equipamento['num_serie'] ?? null,
                    ':num_aparelho' => $equipamento['num_aparelho'] ?? null,
                    ':defeito_reclamado' => $equipamento['defeito_reclamado'] ?? null,
                    ':condicao' => $equipamento['condicao'] ?? null
                ]);

                $id_equipamento = $pdo->lastInsertId();

                // Processar serviços do equipamento
                if (isset($equipamento['servicos'])) {
                    foreach ($equipamento['servicos'] as $servico) {
                        // Inserir serviço
                        $sql_serv = "INSERT INTO servicos_os (id_equipamento, tipo_servico, descricao, valor) 
                                     VALUES (:id_equipamento, :tipo_servico, :descricao, :valor)";
                        $stmt_serv = $pdo->prepare($sql_serv);
                        $stmt_serv->execute([
                            ':id_equipamento' => $id_equipamento,
                            ':tipo_servico' => $servico['tipo_servico'],
                            ':descricao' => $servico['descricao'] ?? null,
                            ':valor' => $servico['valor']
                        ]);

                        // Diminuir estoque se uma peça foi selecionada
                        if (!empty($servico['id_produto'])) {
                            // Primeiro, buscar o preço da peça
                            $sql_preco = "SELECT preco FROM produto WHERE id_produto = :id_produto";
                            $stmt_preco = $pdo->prepare($sql_preco);
                            $stmt_preco->execute([':id_produto' => $servico['id_produto']]);
                            $produto = $stmt_preco->fetch(PDO::FETCH_ASSOC);

                            $valor_peca = $produto['preco'];

                            // Atualizar estoque
                            $sql_update_estoque = "UPDATE produto 
                                                  SET quantidade = quantidade - 1 
                                                  WHERE id_produto = :id_produto AND quantidade > 0";
                            $stmt_estoque = $pdo->prepare($sql_update_estoque);
                            $stmt_estoque->execute([':id_produto' => $servico['id_produto']]);

                            if ($stmt_estoque->rowCount() === 0) {
                                throw new Exception("Produto selecionado não está disponível em estoque");
                            }

                            // Registrar na tabela os_produto
                            $sql_os_produto = "INSERT INTO os_produto (id_os, id_produto, quantidade, valor_unitario, valor_total) 
                                              VALUES (:id_os, :id_produto, 1, :valor_unitario, :valor_total)";
                            $stmt_os_produto = $pdo->prepare($sql_os_produto);
                            $stmt_os_produto->execute([
                                ':id_os' => $id_os,
                                ':id_produto' => $servico['id_produto'],
                                ':valor_unitario' => $valor_peca,
                                ':valor_total' => $valor_peca
                            ]);
                        }
                    }
                }
            }
        }

        $pdo->commit();

        $_SESSION['notyf_message'] = "Ordem de serviço cadastrada com sucesso!";
        $_SESSION['notyf_type'] = "success";
        header("Location: os.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['notyf_message'] = "Erro ao cadastrar ordem de serviço: " . $e->getMessage();
        $_SESSION['notyf_type'] = "error";
        header("Location: os.php");
        exit;
    }
}
?>