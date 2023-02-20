<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Conducteurs');


$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Code');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Catégorie');
$phpExcel->getActiveSheet()->setCellValue('C1', 'Nom');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Prénom');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Entreprise');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Adresse');
$phpExcel->getActiveSheet()->setCellValue('G1', 'Fixe');
$phpExcel->getActiveSheet()->setCellValue('H1', 'Mobile');
$phpExcel->getActiveSheet()->setCellValue('I1', 'Email');
$phpExcel->getActiveSheet()->setCellValue('J1', 'Fonction');
$i=2;
foreach ($models as $model):
  
    $phpExcel->getActiveSheet()->setCellValue('A'.$i, $model['Customer']['code']);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i, $model['CustomerCategory']['name']);
    $phpExcel->getActiveSheet()->setCellValue('C'.$i, $model['Customer']['first_name']);
    $phpExcel->getActiveSheet()->setCellValue('D'.$i, $model['Customer']['last_name']);
    $phpExcel->getActiveSheet()->setCellValue('E'.$i, $model['Customer']['company']);
    $phpExcel->getActiveSheet()->setCellValue('F'.$i, $model['Customer']['adress']);
    $phpExcel->getActiveSheet()->setCellValue('G'.$i, $model['Customer']['tel']);
    $phpExcel->getActiveSheet()->setCellValue('H'.$i, $model['Customer']['mobile']);
    $phpExcel->getActiveSheet()->setCellValue('I'.$i, $model['Customer']['email1']);
    $phpExcel->getActiveSheet()->setCellValue('J'.$i, $model['Customer']['job']);
    $i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Conducteurs_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

