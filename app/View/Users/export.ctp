<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
  //declare the xls helper
 $xls= new XlsHelper($this);
 
  //input the export file name
 /* $xls->setHeader('Utilisateurs_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Utilisateurs');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Nom');
  $xls->writeString('Prénom');
  $xls->writeString('Email');
  $xls->writeString('Utilisateur');
  $xls->closeRow();
   
  //rows for data
 
  foreach ($models as $model):
    $xls->openRow();
    $xls->writeString($model['User']['first_name']);
    $xls->writeString($model['User']['last_name']);
    $xls->writeString($model['User']['email']);
    $xls->writeString($model['User']['username']);
    $xls->closeRow();
  endforeach;
  
  $xls->addXmlFooter();
  exit();*/






App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Utilisateurs');


$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Nom');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Prénom');
$phpExcel->getActiveSheet()->setCellValue('C1', 'Email');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Utilisateur');

$i=2;
foreach ($models as $model):

   
    $phpExcel->getActiveSheet()->setCellValue('A'.$i, $model['User']['first_name']);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i, $model['User']['last_name']);
    $phpExcel->getActiveSheet()->setCellValue('C'.$i, $model['User']['email']);
    $phpExcel->getActiveSheet()->setCellValue('D'.$i, $model['User']['username']);

$i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Utilisateurs'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;
