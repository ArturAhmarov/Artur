<?php
$connection = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'kursach');
if ($connection == false) {
    die ('Ошибка подключения: ' . mysqli_connect_error());
}
mysqli_query($connection,"SET CHARACTER SET 'cp1251'");
mysqli_query($connection,"SET NAMES 'cp1251'");
$tablename = $_GET['tablename'];
$result = mysqli_query($connection,"SELECT * FROM `$tablename` ");
$header = mysqli_query($connection,"SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='kursach' 
    AND `TABLE_NAME`='$tablename'");

require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage(L);
$pdf->AddFont('Arial','','arial.php');
$pdf->SetFont('Arial');
foreach($header as $heading) {
    foreach($heading as $column_heading)
        $pdf->Cell(35,10,$column_heading,1);
}
foreach($result as $row) {
    $pdf->SetFont('Arial','',12);
    $pdf->Ln();
    foreach($row as $column)
        $pdf->Cell(35,10,$column,1);
}
$pdf->Output();