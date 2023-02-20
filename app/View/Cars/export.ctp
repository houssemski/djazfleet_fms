<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Véhicules');
$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Code');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Marque');
$phpExcel->getActiveSheet()->setCellValue('C1', 'Modèle');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Catégorie');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Type');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Carburant');
$phpExcel->getActiveSheet()->setCellValue('G1', 'Nb places');
$phpExcel->getActiveSheet()->setCellValue('H1', 'Nb portes');
$phpExcel->getActiveSheet()->setCellValue('I1', 'IM.D');
$phpExcel->getActiveSheet()->setCellValue('J1', 'Chassis');
$phpExcel->getActiveSheet()->setCellValue('K1', 'Couleur');
$phpExcel->getActiveSheet()->setCellValue('L1', 'Circulation');
$phpExcel->getActiveSheet()->setCellValue('M1', 'Statut');
$phpExcel->getActiveSheet()->setCellValue('N1', 'Kilométrage');
$i=2;
foreach ($models as $model):

    $phpExcel->getActiveSheet()->setCellValue('A'.$i, $model['Car']['code']);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i, $model['Mark']['name']);
    $phpExcel->getActiveSheet()->setCellValue('C'.$i, $model['Carmodel']['name']);
    $phpExcel->getActiveSheet()->setCellValue('D'.$i, $model['CarCategory']['name']);
    $phpExcel->getActiveSheet()->setCellValue('E'.$i, $model['CarType']['name']);
    $phpExcel->getActiveSheet()->setCellValue('F'.$i, $model['Fuel']['name']);
    $phpExcel->getActiveSheet()->setCellValue('G'.$i, $model['Car']['nbplace']);
    $phpExcel->getActiveSheet()->setCellValue('H'.$i, $model['Car']['nbdoor']);
    $phpExcel->getActiveSheet()->setCellValue('I'.$i, $model['Car']['immatr_def']);
    $phpExcel->getActiveSheet()->setCellValue('J'.$i, $model['Car']['chassis']);
    $phpExcel->getActiveSheet()->setCellValue('K'.$i, $model['Car']['color2']);
    $phpExcel->getActiveSheet()->setCellValue('L'.$i, $this->Time->format($model['Car']['circulation_date'], '%d-%m-%Y'));
    $phpExcel->getActiveSheet()->setCellValue('M'.$i, $model['CarStatus']['name']);
    $phpExcel->getActiveSheet()->setCellValue('N'.$i, $model['Car']['km']);
$i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Véhicules_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

