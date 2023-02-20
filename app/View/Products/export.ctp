<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
    $phpExcel->getActiveSheet()->setTitle('Produits');
$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Code');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Name');
$phpExcel->getActiveSheet()->setCellValue('C1', 'Type');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Mark');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Quantity');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Quantity min');
$phpExcel->getActiveSheet()->setCellValue('G1','Quantity max');





$i=2;
foreach ($models as $model):


    $phpExcel->getActiveSheet()->setCellValue('A'.$i, $model['Product']['code']);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i, $model['Product']['name']);
    $phpExcel->getActiveSheet()->setCellValue('C'.$i, $model['ProductCategory']['name']);
    $phpExcel->getActiveSheet()->setCellValue('D'.$i, $model['ProductMark']['name']);
    $phpExcel->getActiveSheet()->setCellValue('E'.$i, $model['Product']['quantity']);
    $phpExcel->getActiveSheet()->setCellValue('F'.$i, $model['Product']['quantity_min']);
    $phpExcel->getActiveSheet()->setCellValue('G'.$i, $model['Product']['quantity_max']);


    $i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Produits_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

