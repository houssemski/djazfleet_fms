<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Evénements');


$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Code');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Type');
$phpExcel->getActiveSheet()->setCellValue('C1', 'Véhicule');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Conducteur');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Date');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Prochaine date');
$phpExcel->getActiveSheet()->setCellValue('G1', 'Km');
$phpExcel->getActiveSheet()->setCellValue('H1', 'Prochain Km');
$phpExcel->getActiveSheet()->setCellValue('I1', 'Coût');
$phpExcel->getActiveSheet()->setCellValue('J1', 'Intervenant');
$i=2;
foreach ($models as $model):
     if ($param==1){
                         $car= $model['Car']['code']." - ".$model['Carmodel']['name']; 
                         } else if ($param==2) {
                         $car= $model['Car']['immatr_def']." - ".$model['Carmodel']['name']; 
                            }
 
        $customer = $model['Customer']['first_name']." ".$model['Customer']['last_name'];
   
    $date=$this->Time->format($model['Event']['date'], '%d-%m-%Y');
    $next_date=$this->Time->format($model['Event']['next_date'], '%d-%m-%Y');
    $phpExcel->getActiveSheet()->setCellValue('A'.$i, $model['Event']['code']);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i, $model['EventType']['name']);
    $phpExcel->getActiveSheet()->setCellValue('C'.$i, $car);
    $phpExcel->getActiveSheet()->setCellValue('D'.$i, $customer);
    $phpExcel->getActiveSheet()->setCellValue('E'.$i, $date);
    $phpExcel->getActiveSheet()->setCellValue('F'.$i, $next_date);
    $phpExcel->getActiveSheet()->setCellValue('G'.$i, $model['Event']['km']);
    $phpExcel->getActiveSheet()->setCellValue('H'.$i, $model['Event']['next_km']);
    $phpExcel->getActiveSheet()->setCellValue('I'.$i, $model['Event']['cost']);
    $phpExcel->getActiveSheet()->setCellValue('J'.$i, $model['Interfering']['name']);
    $i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Evénements_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

