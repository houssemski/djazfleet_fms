<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Bills');


$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Reference');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Conducteur');
$phpExcel->getActiveSheet()->setCellValue('C1', 'Vehicule');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Immatriculation');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Date debut');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Date fin');
$phpExcel->getActiveSheet()->setCellValue('G1', 'Nombre de jour');
$phpExcel->getActiveSheet()->setCellValue('H1', 'PU/JR');
$phpExcel->getActiveSheet()->setCellValue('I1', 'Montant');

$i=2;
 
foreach ($results as $result):
$reference=$result['customer_car']['reference'];
$car=$result['marks']['name'].' '.$result['carmodels']['name'];
$imm=$result['car']['immatr_def'];
$nb_days=$result[0]['diff_date'];
$cost_day=$result['customer_car']['cost_day'];
$cost=$result['customer_car']['cost'];
 $customer = $result['customers']['first_name'].' '.$result['customers']['last_name'];
  $date_start =$this->Time->format( $result['customer_car']['start'], '%d-%m-%Y');
  $date_end =$this->Time->format( $result['customer_car']['end'], '%d-%m-%Y');  

   $phpExcel->getActiveSheet()->setCellValue('A'.$i,$reference);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i,$customer);
    $phpExcel->getActiveSheet()->setCellValue('C'.$i,$car);
    $phpExcel->getActiveSheet()->setCellValue('D'.$i,$imm);
    $phpExcel->getActiveSheet()->setCellValue('E'.$i,$date_start);
    $phpExcel->getActiveSheet()->setCellValue('F'.$i,$date_end);
    $phpExcel->getActiveSheet()->setCellValue('G'.$i,$nb_days);
    $phpExcel->getActiveSheet()->setCellValue('H'.$i,$cost_day);
    $phpExcel->getActiveSheet()->setCellValue('I'.$i,$cost);
     


   
$i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Facture_'.date('m_Y');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

