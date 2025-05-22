/*Inserir dados*/
INSERT INTO clientes (
    id_cliente,id_usuario, email, nome, observacao, data_nasc, cargo, sexo
) VALUES (
    71,
    60,
    'mariaoliveira@gmail.com',         
    'Maria Oliveira',              
    'Cliente VIP, atenção especial', 
    '1985-07-20',                  
    'Gerente de Vendas',           
    'F'                            
);


/*Consultar dados*/
select p.nome as "Nome da peça", p.descricao as "Descrição", p.data_registro as "Data de cadastro" ,f.nome as "Nome do fornecedor" 
from pecas p
join fornecedor f on f.id_fornecedor = p.id_fornecedor;


/*Atualizar Dados*/

UPDATE pecas
SET data_registro = CASE id_pecas
    WHEN 1 THEN '2024-01-17'
    WHEN 2 THEN '2024-03-05'
    WHEN 3 THEN '2025-02-11'
    WHEN 4 THEN '2024-07-29'
    WHEN 5 THEN '2024-11-12'
    WHEN 6 THEN '2025-01-20'
    WHEN 7 THEN '2024-06-08'
    WHEN 8 THEN '2025-03-01'
    WHEN 9 THEN '2024-08-14'
    WHEN 10 THEN '2024-12-03'
    ELSE data_registro
END
WHERE id_pecas BETWEEN 1 AND 60;


/**/

DELETE FROM cliente WHERE id_pecas = 1;

