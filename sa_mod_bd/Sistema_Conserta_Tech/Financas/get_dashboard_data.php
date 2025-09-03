<?php
require_once("../Conexao/conexao.php");
header('Content-Type: application/json');

$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 30;
$mes = isset($_GET['mes']) ? $_GET['mes'] : '';

// Funções de busca de dados (as mesmas do arquivo principal)
// ... cole aqui as funções PHP definidas anteriormente ...

// Buscar dados com base nos filtros
$dataInicio = date('Y-m-d', strtotime("-$periodo days"));

if (!empty($mes)) {
    $dataInicio = $mes . '-01';
    $periodo = 'custom';
}

$receitaTotal = getReceitaTotal($periodo);
$despesasTotal = getDespesasTotal($periodo);
$lucroLiquido = $receitaTotal - $despesasTotal;
$pagamentosPendentes = getPagamentosPendentes();
$quantidadePendentes = getQuantidadePendentes();
$ultimasOrdens = getUltimasOrdensServico();
$receitaMensal = getReceitaMensal();
$statusPagamentos = getStatusPagamentos();

// Preparar dados para o gráfico de receita/despesas
$meses = [];
$receitas = [];
$despesas = [];

foreach ($receitaMensal as $mes => $valor) {
    $meses[] = date('M/Y', strtotime($mes . '-01'));
    $receitas[] = floatval($valor);
    // Para simplificar, vamos usar 50% da receita como despesa estimada
    $despesas[] = floatval($valor) * 0.5;
}

// Preparar dados para o gráfico de status
$statusData = [
    intval($statusPagamentos['Pago']),
    intval($statusPagamentos['Pendente'])
];

// Retornar dados em JSON
echo json_encode([
    'receitaTotal' => $receitaTotal,
    'despesasTotal' => $despesasTotal,
    'lucroLiquido' => $lucroLiquido,
    'pagamentosPendentes' => $pagamentosPendentes,
    'quantidadePendentes' => $quantidadePendentes,
    'meses' => $meses,
    'receitas' => $receitas,
    'despesas' => $despesas,
    'statusPagamentos' => $statusData,
    'ultimasOrdens' => $ultimasOrdens
]);
?>