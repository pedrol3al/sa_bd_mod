<?php
require('fpdf/fpdf.php');
require_once '../Conexao/conexao.php';

if(!isset($_GET['id_os'])){
    die("OS não informada!");
}

$id_os = (int) $_GET['id_os'];

// Busca dados da OS + cliente
$sql = "SELECT 
            os.id_os,
            cliente.nome AS nome_cliente,
            cliente.email,
            cliente.telefone,
            os.num_serie,
            os.data_abertura,
            os.data_termino,
            os.modelo,
            os.num_aparelho,
            os.defeito_rlt,
            os.condicao,
            os.fabricante,
            os.status,
            os.observacoes
        FROM os
        INNER JOIN cliente ON os.id_cliente = cliente.id_cliente
        WHERE os.id_os = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id',$id_os,PDO::PARAM_INT);
$stmt->execute();
$os = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$os){
    die("OS não encontrada!");
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'NOTA FISCAL (simulacao)',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Cliente: '.utf8_decode($os['nome_cliente']),0,1);
$pdf->Cell(0,10,'Telefone: '.$os['telefone'],0,1);
$pdf->Cell(0,10,'Email: '.$os['email'],0,1);
$pdf->Ln(5);

$pdf->Cell(0,10,'Ordem de Servico: '.$os['id_os'],0,1);
$pdf->Cell(0,10,'Numero de serie: '.$os['num_serie'],0,1);
$pdf->Cell(0,10,'Modelo: '.$os['modelo'],0,1);
$pdf->Cell(0,10,'Fabricante: '.$os['fabricante'],0,1);
$pdf->Cell(0,10,'Abertura: '.date('d/m/Y', strtotime($os['data_abertura'])),0,1);
$pdf->Cell(0,10,'Termino: '.($os['data_termino'] ? date('d/m/Y', strtotime($os['data_termino'])) : '-'),0,1);
$pdf->Cell(0,10,'Status: '.$os['status'],0,1);
$pdf->Ln(5);

$pdf->MultiCell(0,10,'Defeito relatado: '.utf8_decode($os['defeito_rlt']));
$pdf->MultiCell(0,10,'Observacoes: '.utf8_decode($os['observacoes']));

$pdf->Output('I','nota_fiscal.pdf');
?>